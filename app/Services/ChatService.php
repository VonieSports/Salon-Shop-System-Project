<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use App\Models\Employee;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ChatService
{

 protected $blockUserService;

    public function __construct(BlockUserService $blockUserService)
    {
        $this->blockUserService = $blockUserService;
    }

     public function toggleBlockUser(int $userId, int $blockedUserId): bool
    {
        return $this->blockUserService->toggleBlock($userId, $blockedUserId);
    }

    public function isUserBlocked(int $userId, int $blockedUserId): bool
    {
        return $this->blockUserService->isBlocked($userId, $blockedUserId);
    }

    public function canCommunicate(int $userId, int $otherUserId): bool
    {
        return $this->blockUserService->canCommunicate($userId, $otherUserId);
    }

    public function deleteConversation(int $conversationId, int $userId): bool
    {
        try {
            $conversation = Conversation::where('id', $conversationId)
                ->whereHas('participants', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->first();

            if (!$conversation) {
                return false;
            }

            $conversation->participants()->updateExistingPivot($userId, [
                'is_active' => false,
                'left_at' => now(),
            ]);

            $activeParticipants = $conversation->participants()
                ->wherePivot('is_active', true)
                ->count();

            if ($activeParticipants === 0) {
                $conversation->delete();
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Delete conversation error: ' . $e->getMessage());
            return false;
        }
    }

    public function getOrCreateDirectConversation(int $userId, int $otherUserId, int $tenantId): Conversation
    {
        $conversation = Conversation::where('tenant_id', $tenantId)
            ->where('type', 'direct')
            ->whereHas('participants', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->where('conversation_participants.is_active', 1);
            })
            ->whereHas('participants', function ($query) use ($otherUserId) {
                $query->where('user_id', $otherUserId)
                      ->where('conversation_participants.is_active', 1);
            })
            ->first();

        if ($conversation) {
            return $conversation;
        }

        return DB::transaction(function () use ($tenantId, $userId, $otherUserId) {
            $conversation = Conversation::create([
                'tenant_id' => $tenantId,
                'type' => 'direct',
                'last_message_at' => now(),
            ]);

            $conversation->participants()->attach([
                $userId => ['is_active' => true],
                $otherUserId => ['is_active' => true],
            ]);

            return $conversation;
        });
    }

    public function createGroupConversation(int $tenantId, string $name, array $participantIds): Conversation
    {
        return DB::transaction(function () use ($tenantId, $name, $participantIds) {
            $conversation = Conversation::create([
                'tenant_id' => $tenantId,
                'name' => $name,
                'type' => 'group',
                'last_message_at' => now(),
            ]);

            $participants = [];
            foreach ($participantIds as $userId) {
                $participants[$userId] = ['is_active' => true];
            }

            $conversation->participants()->attach($participants);

            return $conversation;
        });
    }

 public function sendMessage(int $conversationId, int $userId, string $content, $file = null): Message
{
    return DB::transaction(function () use ($conversationId, $userId, $content, $file) {
        $filePath = null;
        $fileName = null;
        $type = 'text';

        if ($file) {
            try {
                $filePath = $file->store('chat_files', 'public');
                $fileName = $file->getClientOriginalName();
                $type = 'file';
            } catch (\Exception $e) {
                Log::error('File upload error: ' . $e->getMessage());
                throw new \Exception('Failed to upload file: ' . $e->getMessage());
            }
        }

        $messageContent = $content;
        if (empty($messageContent) && $file) {
            $messageContent = '📎 ' . ($fileName ?? 'File shared');
        } elseif (empty($messageContent)) {
            $messageContent = ' '; 
        }

        $message = Message::create([
            'conversation_id' => $conversationId,
            'user_id' => $userId,
            'content' => $messageContent,
            'type' => $type,
            'file_path' => $filePath,
            'file_name' => $fileName,
        ]);

        Conversation::where('id', $conversationId)->update([
            'last_message_at' => now(),
        ]);

        return $message;
    });
}

    public function getMessages(int $conversationId)
    {
        return Message::where('conversation_id', $conversationId)
            ->with(['user'])
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function getUserConversations(int $userId, int $tenantId)
    {
        return Conversation::where('tenant_id', $tenantId)
            ->whereHas('participants', function ($query) use ($userId) {
                $query->where('user_id', $userId)
                      ->where('conversation_participants.is_active', 1);
            })
            ->with(['participants', 'lastMessage'])
            ->orderBy('last_message_at', 'desc')
            ->get()
            ->map(function ($conversation) use ($userId) {
                $conversation->unread_count = $this->getUnreadCountFromOthers($conversation->id, $userId);
                $conversation->display_name = $this->getConversationDisplayName($conversation, $userId);
                $conversation->display_avatar = $this->getConversationAvatar($conversation, $userId);
                return $conversation;
            });
    }

     public function getUnreadCountFromOthers(int $conversationId, int $userId): int
    {
        return Message::where('conversation_id', $conversationId)
            ->where('user_id', '!=', $userId) // Only messages from OTHER users
            ->whereDoesntHave('reads', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->count();
    }

      public function getUnreadCount(int $conversationId, int $userId): int
    {
        return Message::where('conversation_id', $conversationId)
            ->whereDoesntHave('reads', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->count();
    }

    public function markMessagesAsRead(int $conversationId, int $userId): void
    {
        $messages = Message::where('conversation_id', $conversationId)
            ->whereDoesntHave('reads', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->get();

        foreach ($messages as $message) {
            $message->reads()->create([
                'user_id' => $userId,
                'read_at' => now(),
            ]);
        }
    }

    public function getConversationDisplayName(Conversation $conversation, int $userId): string
    {
        if ($conversation->type === 'group') {
            return $conversation->name;
        }

        $otherUser = $conversation->participants()
            ->where('user_id', '!=', $userId)
            ->first();

        return $otherUser ? $otherUser->name : 'Unknown';
    }

    public function getConversationAvatar(Conversation $conversation, int $userId): ?string
    {
        if ($conversation->type === 'group') {
            return null;
        }

        $otherUser = $conversation->participants()
            ->where('user_id', '!=', $userId)
            ->first();

        return $otherUser ? $otherUser->avatar : null;
    }

    public function getAvailableUsers(int $tenantId, int $currentUserId)
    {
        $tenant = Tenant::with('owner')->find($tenantId);
        
        if (!$tenant) {
            return collect();
        }

        $employeeUserIds = Employee::where('tenant_id', $tenantId)
            ->where('is_active', true)
            ->pluck('user_id')
            ->toArray();

        $ownerId = $tenant->owner?->id;

        $userIds = array_unique(array_merge($employeeUserIds, [$ownerId]));
        $userIds = array_filter($userIds, function ($id) use ($currentUserId) {
            return $id != $currentUserId && $id !== null;
        });

        if (empty($userIds)) {
            return collect();
        }

        $users = User::whereIn('id', $userIds)
            ->where('is_active', true)
            ->get();

        return $users->map(function ($user) use ($tenantId, $ownerId) {
            $employee = Employee::where('user_id', $user->id)
                ->where('tenant_id', $tenantId)
                ->first();
                
            if ($employee) {
                $user->position = $employee->position;
            } elseif ($user->id == $ownerId) {
                $user->position = 'Owner';
            } else {
                $user->position = 'Staff';
            }
            
            return $user;
        });
    }

};
<?php

namespace App\Services;

use App\Models\User;
use App\Models\Conversation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BlockUserService
{
  
    public function blockUser(int $userId, int $blockedUserId): bool
    {
        try {
            $user = User::find($userId);
            $blockedUser = User::find($blockedUserId);
            
            if (!$user || !$blockedUser) {
                return false;
            }

            if ($this->isBlocked($userId, $blockedUserId)) {
                return false;
            }

            DB::transaction(function () use ($user, $blockedUser, $blockedUserId) {
                $user->blockedUsers()->attach($blockedUserId);
                
                $blockedUser->update(['is_blocked' => true]);
                
                $this->updateConversationBlockStatus($user->id, $blockedUserId, true);
            });

            return true;
            
        } catch (\Exception $e) {
            Log::error('Block user error: ' . $e->getMessage());
            return false;
        }
    }

    public function unblockUser(int $userId, int $blockedUserId): bool
    {
        try {
            $user = User::find($userId);
            $blockedUser = User::find($blockedUserId);
            
            if (!$user || !$blockedUser) {
                return false;
            }

            if (!$this->isBlocked($userId, $blockedUserId)) {
                return false;
            }

            DB::transaction(function () use ($user, $blockedUser, $blockedUserId) {
                $user->blockedUsers()->detach($blockedUserId);
                
                $isBlockedByOthers = $blockedUser->blockedBy()->exists();
                
                if (!$isBlockedByOthers) {
                    $blockedUser->update(['is_blocked' => false]);
                }
                
                $this->updateConversationBlockStatus($user->id, $blockedUserId, false);
            });

            return true;
            
        } catch (\Exception $e) {
            Log::error('Unblock user error: ' . $e->getMessage());
            return false;
        }
    }

    public function toggleBlock(int $userId, int $blockedUserId): bool
    {
        if ($this->isBlocked($userId, $blockedUserId)) {
            return $this->unblockUser($userId, $blockedUserId);
        }
        return $this->blockUser($userId, $blockedUserId);
    }

    public function isBlocked(int $userId, int $blockedUserId): bool
    {
        try {
            $user = User::find($userId);
            if (!$user) {
                return false;
            }
            return $user->blockedUsers()->where('blocked_user_id', $blockedUserId)->exists();
        } catch (\Exception $e) {
            Log::error('Check blocked error: ' . $e->getMessage());
            return false;
        }
    }

    public function getBlockedUsers(int $userId): array
    {
        try {
            $user = User::find($userId);
            if (!$user) {
                return [];
            }
            return $user->blockedUsers()->pluck('blocked_user_id')->toArray();
        } catch (\Exception $e) {
            Log::error('Get blocked users error: ' . $e->getMessage());
            return [];
        }
    }

    public function canCommunicate(int $userId, int $otherUserId): bool
    {
        if ($this->isBlocked($userId, $otherUserId)) {
            return false;
        }
        
        if ($this->isBlocked($otherUserId, $userId)) {
            return false;
        }
        
        return true;
    }

    private function updateConversationBlockStatus(int $userId, int $blockedUserId, bool $isBlocked): void
    {
        try {
            $conversation = Conversation::where('type', 'direct')
                ->whereHas('participants', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->whereHas('participants', function ($query) use ($blockedUserId) {
                    $query->where('user_id', $blockedUserId);
                })
                ->first();
                
            if ($conversation) {
                $conversation->participants()->updateExistingPivot($blockedUserId, [
                    'blocked_at' => $isBlocked ? now() : null
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Update conversation block status error: ' . $e->getMessage());
        }
    }
};
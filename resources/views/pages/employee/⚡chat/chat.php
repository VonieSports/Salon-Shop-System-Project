<?php

use App\Models\User;
use Livewire\Component;
use App\Services\ChatService;
use App\Models\Conversation;
use App\Models\Employee;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

new #[Layout('layouts.employee')] class extends Component
{
    use WithFileUploads;

    public $tenantId;
    public $conversations = [];
    public $selectedConversation = null;
    public $chatMessages = [];
    public $newMessage = '';
    public $file = null;
    public $showNewChatModal = false;
    public $selectedUsers = [];
    public $chatName = '';
    public $allUsers = [];
    public $isGroupChat = false;
    public $loading = false;
    public $searchTerm = '';
    public $previewFile = null;
    public $showSidebar = true;
    public $errorMessage = '';
    public $successMessage = '';
 
    public $showMembersModal = false;
    public $memberSearch = '';
    public $addMemberSearch = '';
    public $availableUsersToAdd = [];
    
    public $showChatActions = false;

    public function mount()
    {
        $user = auth()->user();
        $employee = Employee::where('user_id', $user->id)->first();
        
        if (!$employee) {
            $this->errorMessage = 'No employee record found. Please contact your administrator.';
            return;
        }
        
        $this->tenantId = $employee->tenant_id;
        $this->loadConversations();
        $this->loadUsers();
    }

    public function loadConversations()
    {
        $chatService = app(ChatService::class);
        $this->conversations = $chatService->getUserConversations(auth()->id(), $this->tenantId);
    }

    public function loadUsers()
    {
        $chatService = app(ChatService::class);
        $this->allUsers = $chatService->getAvailableUsers($this->tenantId, auth()->id());
    }

    public function selectConversation($conversationId)
    {
        $this->loading = true;
        $this->errorMessage = '';
        $this->successMessage = '';
        
        $this->selectedConversation = Conversation::with(['messages.user', 'participants'])
            ->find($conversationId);

        if ($this->selectedConversation) {
            $chatService = app(ChatService::class);
            $this->chatMessages = $chatService->getMessages($conversationId);
            $chatService->markMessagesAsRead($conversationId, auth()->id());
            $this->loadConversations();
            
            $this->memberSearch = '';
            $this->addMemberSearch = '';
            $this->loadAvailableUsersToAdd();
            
            $this->showSidebar = false;
        }

        $this->loading = false;
        $this->dispatch('messageLoaded');
    }

    public function loadAvailableUsersToAdd()
    {
        if (!$this->selectedConversation) {
            $this->availableUsersToAdd = collect();
            return;
        }

        $participantIds = $this->selectedConversation->participants->pluck('id')->toArray();
        $allUsers = $this->allUsers;
        
        $this->availableUsersToAdd = $allUsers->filter(function($user) use ($participantIds) {
            return !in_array($user->id, $participantIds);
        });
        
        if (!empty($this->addMemberSearch)) {
            $this->availableUsersToAdd = $this->availableUsersToAdd->filter(function($user) {
                return stripos($user->name, $this->addMemberSearch) !== false;
            });
        }
    }

    public function updatedAddMemberSearch()
    {
        $this->loadAvailableUsersToAdd();
    }

    public function updatedMemberSearch()
    {
        // Refresh view
    }

    public function openMembersModal()
    {
        $this->showMembersModal = true;
        $this->memberSearch = '';
        $this->addMemberSearch = '';
        $this->loadAvailableUsersToAdd();
    }

    public function addMemberToGroup($userId)
    {
        try {
            $conversation = $this->selectedConversation;
            
            if ($conversation->participants->contains($userId)) {
                $this->errorMessage = 'User is already in this conversation.';
                return;
            }

            DB::transaction(function () use ($conversation, $userId) {
                $conversation->participants()->attach($userId, ['is_active' => true]);
            });

            $this->selectedConversation = Conversation::with(['messages.user', 'participants'])
                ->find($conversation->id);
                
            $this->loadAvailableUsersToAdd();
            $this->successMessage = 'Member added successfully!';
            
        } catch (\Exception $e) {
            $this->errorMessage = 'Failed to add member: ' . $e->getMessage();
        }
    }

    public function removeMember($userId)
    {
        try {
            $conversation = $this->selectedConversation;
            
            if ($userId == auth()->id()) {
                $this->errorMessage = 'You cannot remove yourself.';
                return;
            }

            DB::transaction(function () use ($conversation, $userId) {
                $conversation->participants()->detach($userId);
            });

            $this->selectedConversation = Conversation::with(['messages.user', 'participants'])
                ->find($conversation->id);
                
            $this->loadAvailableUsersToAdd();
            $this->successMessage = 'Member removed successfully!';
            
        } catch (\Exception $e) {
            $this->errorMessage = 'Failed to remove member: ' . $e->getMessage();
        }
    }

    public function openChatActions()
    {
        $this->showChatActions = true;
    }

    public function toggleBlockUser($userId)
    {
        try {
            $chatService = app(ChatService::class);
            $success = $chatService->toggleBlockUser(auth()->id(), $userId);
            
            if ($success) {
                $user = User::find($userId);
                $isBlocked = $chatService->isUserBlocked(auth()->id(), $userId);
                $this->successMessage = $isBlocked ? 'User blocked successfully!' : 'User unblocked successfully!';
                $this->selectedConversation = Conversation::with(['messages.user', 'participants'])
                    ->find($this->selectedConversation->id);
            } else {
                $this->errorMessage = 'Failed to toggle block status.';
            }
            
            $this->showChatActions = false;
            
        } catch (\Exception $e) {
            $this->errorMessage = 'Failed to toggle block status: ' . $e->getMessage();
        }
    }

    public function deleteConversation()
    {
        try {
            $chatService = app(ChatService::class);
            $success = $chatService->deleteConversation($this->selectedConversation->id, auth()->id());
            
            if ($success) {
                $this->successMessage = 'Conversation deleted successfully!';
                $this->selectedConversation = null;
                $this->showSidebar = true;
                $this->showChatActions = false;
                $this->loadConversations();
            } else {
                $this->errorMessage = 'Failed to delete conversation.';
            }
            
        } catch (\Exception $e) {
            $this->errorMessage = 'Failed to delete conversation: ' . $e->getMessage();
        }
    }

    public function goBackToSidebar()
    {
        $this->showSidebar = true;
        $this->selectedConversation = null;
        $this->showMembersModal = false;
        $this->showChatActions = false;
        $this->loadConversations();
    }

    public function sendMessage()
    {
        if (empty($this->newMessage) && !$this->file) {
            return;
        }

        try {
            $chatService = app(ChatService::class);
            
            $otherUser = $this->selectedConversation->participants()
                ->where('user_id', '!=', auth()->id())
                ->first();
                
            if ($otherUser && !$chatService->canCommunicate(auth()->id(), $otherUser->id)) {
                $this->errorMessage = 'You cannot send messages to this user.';
                return;
            }
            
            $messageContent = $this->newMessage ?: '';
            
            $chatService->sendMessage(
                $this->selectedConversation->id,
                auth()->id(),
                $messageContent,
                $this->file
            );

            $this->chatMessages = $chatService->getMessages($this->selectedConversation->id);
            $this->newMessage = '';
            $this->file = null;
            $this->loadConversations();

        } catch (\Exception $e) {
            $this->errorMessage = 'Failed to send message: ' . $e->getMessage();
        }
    }

    public function previewFile($filePath, $fileName)
    {
        try {
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'bmp', 'ico']);
            
            $this->previewFile = [
                'path' => $filePath,
                'name' => $fileName ?? 'File',
                'type' => $isImage ? 'image' : 'file'
            ];
        } catch (\Exception $e) {
            $this->previewFile = null;
        }
    }

    public function clearPreview()
    {
        $this->previewFile = null;
    }

    public function startNewChat()
    {
        $this->showNewChatModal = true;
        $this->selectedUsers = [];
        $this->chatName = '';
        $this->isGroupChat = false;
        $this->errorMessage = '';
        $this->successMessage = '';
        $this->loadUsers();
    }

    public function createNewChat()
    {
        try {
            if (!is_array($this->selectedUsers)) {
                $this->selectedUsers = [];
            }
            
            if (empty($this->selectedUsers)) {
                $this->errorMessage = 'Please select a user to chat with.';
                return;
            }

            $chatService = app(ChatService::class);
            $userId = auth()->id();

            DB::beginTransaction();

            if ($this->isGroupChat) {
                if (empty($this->chatName)) {
                    $this->errorMessage = 'Please enter a group name.';
                    return;
                }
                $participants = array_merge([$userId], $this->selectedUsers);
                $conversation = $chatService->createGroupConversation(
                    $this->tenantId,
                    $this->chatName,
                    $participants
                );
            } else {
                $otherUserId = (int) $this->selectedUsers[0];
                
                if ($otherUserId == $userId) {
                    $this->errorMessage = 'You cannot chat with yourself.';
                    return;
                }
                
                $conversation = $chatService->getOrCreateDirectConversation(
                    $userId,
                    $otherUserId,
                    $this->tenantId
                );
            }

            DB::commit();

            $this->showNewChatModal = false;
            $this->selectedUsers = [];
            
            $this->selectConversation($conversation->id);
            $this->loadConversations();
            
            $this->successMessage = 'Chat started successfully!';
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->errorMessage = 'Failed to create chat: ' . $e->getMessage();
        }
    }

    public function updatedSelectedUsers($value)
    {
        if (!is_array($value)) {
            $this->selectedUsers = [$value];
        }
    }
};
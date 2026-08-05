<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

new #[Layout('layouts.salon_owner')] class extends Component
{
    use WithFileUploads;

    public $user;
    public $showCoverMenu = false;
    public $newCoverPhoto;

    public function mount()
    {
        $this->user = Auth::user()->load('tenant');
    }

    #[Computed]
    public function coverPhotoUrl()
    {
        return $this->user->cover_photo ? Storage::url($this->user->cover_photo) : null;
    }

    #[Computed]
    public function avatarUrl()
    {
        if ($this->user->avatar) {
            return Storage::url($this->user->avatar);
        }
        
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->user->name) . '&background=1E7A4A&color=fff&size=128';
    }

    public function updatedNewCoverPhoto()
    {
        $this->validate([
            'newCoverPhoto' => 'image|max:5120',
        ]);

        try {
            if ($this->user->cover_photo) {
                Storage::disk('public')->delete($this->user->cover_photo);
            }

            $path = $this->newCoverPhoto->store('cover_photos', 'public');
            $this->user->update(['cover_photo' => $path]);

            $this->user->refresh();
            $this->newCoverPhoto = null;
            $this->showCoverMenu = false;

            session()->flash('success', 'Cover photo updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to upload cover photo.');
        }
    }

    public function removeCoverPhoto()
    {
        if ($this->user->cover_photo) {
            Storage::disk('public')->delete($this->user->cover_photo);
            $this->user->update(['cover_photo' => null]);
            $this->user->refresh();
            $this->showCoverMenu = false;

            session()->flash('success', 'Cover photo removed successfully!');
        }
    }
};
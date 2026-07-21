<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\Attributes\Computed;

new #[Layout('layouts.employee')] class extends Component
{
    use WithFileUploads;

    public $user;
    public $employeeData;
    public $status;
    public $showCoverMenu = false;
    public $newCoverPhoto;

    #[Computed]
    public function coverPhoto()
    {
        return $this->user->cover_photo;
    }

    #[Computed]
    public function avatar()
    {
        return $this->user->avatar;
    }

    public function mount()
    {
        $this->user = Auth::user()->load('employeeProfile');
        $this->employeeData = $this->user->employeeProfile;
        $this->status = $this->user->status;
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
            $this->employeeData = $this->user->employeeProfile;
            $this->status = $this->user->status;
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
            $this->employeeData = $this->user->employeeProfile;
            $this->status = $this->user->status;
            $this->showCoverMenu = false;

            session()->flash('success', 'Cover photo removed successfully!');
        }
    }

    public function toggleCoverMenu()
    {
        $this->showCoverMenu = !$this->showCoverMenu;
    }
};
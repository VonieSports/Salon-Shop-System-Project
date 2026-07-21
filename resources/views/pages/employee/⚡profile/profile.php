<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

new #[Layout('layouts.employee')] class extends Component
{
   use WithFileUploads;

    public $user;
    public $employeeData;
    public $status;
    public $newCoverPhoto;

    public function mount()
    {
        $this->user = auth()->user();
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

            $this->user = auth()->user();
            $this->newCoverPhoto = null;

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

            $this->user = auth()->user();

            session()->flash('success', 'Cover photo removed successfully!');
        }
    }
};
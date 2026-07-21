<?php

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;

new #[Layout('layouts.employee')] class extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $phone;
    public $address;
    public $bio;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;
    public $avatar;
    public $cover_photo;
    public $existing_avatar;
    public $existing_cover_photo;

    public $user;
    public $employeeData;
    public $status;

    public function mount()
    {
        $this->user = Auth::user()->load('employeeProfile');
        $this->employeeData = $this->user->employeeProfile;
        $this->status = $this->user->status;

        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->address = $this->user->address;
        $this->bio = $this->user->bio;
        $this->existing_avatar = $this->user->avatar;
        $this->existing_cover_photo = $this->user->cover_photo;
    }

    protected function rules()
    {
        $user = Auth::user();

        return [
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$user->id}",
            'phone' => "nullable|string|max:11|min:11|unique:users,phone,{$user->id}",
            'address' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|max:2048',
            'cover_photo' => 'nullable|image|max:5120',
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => 'nullable|min:8|confirmed',
        ];
    }

    protected function messages()
    {
        return [
            'cover_photo.image' => 'Cover photo must be an image file.',
            'cover_photo.max' => 'Cover photo must not exceed 5MB.',
            'avatar.image' => 'Profile photo must be an image file.',
            'avatar.max' => 'Profile photo must not exceed 2MB.',
        ];
    }

    public function updatedAvatar()
    {
        $this->validateOnly('avatar');

        try {
            if ($this->existing_avatar) {
                Storage::disk('public')->delete($this->existing_avatar);
            }

            $avatarPath = $this->avatar->store('avatars', 'public');
            $this->user->update(['avatar' => $avatarPath]);
            $this->existing_avatar = $avatarPath;
            $this->avatar = null;

            $this->user = Auth::user()->load('employeeProfile');
            $this->employeeData = $this->user->employeeProfile;
            $this->status = $this->user->status;

            session()->flash('success', 'Profile photo updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to upload profile photo.');
        }
    }

    public function updatedCoverPhoto()
    {
        $this->validateOnly('cover_photo');

        try {
            if ($this->existing_cover_photo) {
                Storage::disk('public')->delete($this->existing_cover_photo);
            }

            $coverPath = $this->cover_photo->store('cover_photos', 'public');
            $this->user->update(['cover_photo' => $coverPath]);
            $this->existing_cover_photo = $coverPath;
            $this->cover_photo = null;

            $this->user = Auth::user()->load('employeeProfile');
            $this->employeeData = $this->user->employeeProfile;
            $this->status = $this->user->status;

            session()->flash('success', 'Cover photo updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to upload cover photo.');
        }
    }

    public function updateProfile()
    {
        $this->validate();

        DB::transaction(function () {
            $user = Auth::user();

            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'bio' => $this->bio,
            ]);

            if ($this->new_password) {
                $user->update(['password' => Hash::make($this->new_password)]);
            }
        });

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        
        $this->user = Auth::user()->load('employeeProfile');
        $this->employeeData = $this->user->employeeProfile;
        $this->status = $this->user->status;
        
        session()->flash('success', 'Profile updated successfully!');
    }

    public function removeAvatar()
    {
        if ($this->user->avatar) {
            Storage::disk('public')->delete($this->user->avatar);
            $this->user->update(['avatar' => null]);
            $this->existing_avatar = null;
            
            $this->user = Auth::user()->load('employeeProfile');
            $this->employeeData = $this->user->employeeProfile;
            $this->status = $this->user->status;
            
            session()->flash('success', 'Profile photo removed successfully!');
        }
    }

    public function removeCoverPhoto()
    {
        if ($this->user->cover_photo) {
            Storage::disk('public')->delete($this->user->cover_photo);
            $this->user->update(['cover_photo' => null]);
            $this->existing_cover_photo = null;
            
            $this->user = Auth::user()->load('employeeProfile');
            $this->employeeData = $this->user->employeeProfile;
            $this->status = $this->user->status;
            
            session()->flash('success', 'Cover photo removed successfully!');
        }
    }
};
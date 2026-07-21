<?php

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;

new #[Layout('layouts.salon_owner')] class extends Component
{
    use WithFileUploads;

    public $user_name;
    public $user_email;
    public $user_phone;
    public $user_address;
    public $user_bio;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;
    public $avatar;
    public $cover_photo;
    public $existing_avatar;
    public $existing_cover_photo;

    public $tenant_name;
    public $tenant_phone;
    public $tenant_email;
    public $tenant_address;

    public $user;
    public $tenant;

    public function mount()
    {
        $this->user = Auth::user()->load('tenant');
        $this->tenant = $this->user->tenant;

        $this->user_name = $this->user->name;
        $this->user_email = $this->user->email;
        $this->user_phone = $this->user->phone;
        $this->user_address = $this->user->address;
        $this->user_bio = $this->user->bio;
        $this->existing_avatar = $this->user->avatar;
        $this->existing_cover_photo = $this->user->cover_photo;

        if ($this->tenant) {
            $this->tenant_name = $this->tenant->name;
            $this->tenant_phone = $this->tenant->phone;
            $this->tenant_email = $this->tenant->email;
            $this->tenant_address = $this->tenant->address;
        }
    }

    protected function rules()
    {
        $user = Auth::user();
        $tenant = $user->tenant;

        $rules = [
            'user_name' => 'required|string|max:255',
            'user_email' => "required|email|unique:users,email,{$user->id}",
            'user_phone' => "nullable|string|max:11|min:11|unique:users,phone,{$user->id}",
            'user_address' => 'nullable|string|max:500',
            'user_bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|max:2048',
            'cover_photo' => 'nullable|image|max:5120',
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => 'nullable|min:8|confirmed',
        ];

        if ($tenant) {
            $rules['tenant_email'] = "nullable|email|unique:tenants,email,{$tenant->id}";
        } else {
            $rules['tenant_email'] = 'nullable|email';
        }

        return $rules;
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

    public function updateProfile()
    {
        $this->validate();

        DB::transaction(function () {
            $user = Auth::user();
            $tenant = $user->tenant;

            $user->update([
                'name' => $this->user_name,
                'email' => $this->user_email,
                'phone' => $this->user_phone,
                'address' => $this->user_address,
                'bio' => $this->user_bio,
            ]);

            if ($this->new_password) {
                $user->update(['password' => Hash::make($this->new_password)]);
            }

            if ($this->avatar) {
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $avatarPath = $this->avatar->store('avatars', 'public');
                $user->update(['avatar' => $avatarPath]);
                $this->existing_avatar = $avatarPath;
                $this->avatar = null;
            }

            if ($this->cover_photo) {
                if ($user->cover_photo) {
                    Storage::disk('public')->delete($user->cover_photo);
                }
                $coverPath = $this->cover_photo->store('cover_photos', 'public');
                $user->update(['cover_photo' => $coverPath]);
                $this->existing_cover_photo = $coverPath;
                $this->cover_photo = null;
            }

            if ($tenant) {
                $tenant->update([
                    'name' => $this->tenant_name,
                    'phone' => $this->tenant_phone,
                    'email' => $this->tenant_email,
                    'address' => $this->tenant_address,
                ]);
            }
        });

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
 
        $this->user = Auth::user()->load('tenant');
        $this->tenant = $this->user->tenant;
        
        session()->flash('success', 'Profile updated successfully!');
    }

    public function removeAvatar()
    {
        if ($this->user->avatar) {
            Storage::disk('public')->delete($this->user->avatar);
            $this->user->update(['avatar' => null]);
            $this->existing_avatar = null;
            session()->flash('success', 'Profile photo removed successfully!');
        }
    }

    public function removeCoverPhoto()
    {
        if ($this->user->cover_photo) {
            Storage::disk('public')->delete($this->user->cover_photo);
            $this->user->update(['cover_photo' => null]);
            $this->existing_cover_photo = null;
            session()->flash('success', 'Cover photo removed successfully!');
        }
    }
};
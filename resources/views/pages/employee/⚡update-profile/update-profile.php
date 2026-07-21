<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

new #[Layout('layouts.employee')] class extends Component
{
    use WithFileUploads;

    public $user;
    public $employeeData;
    public $status;

    // Profile fields
    public $name;
    public $email;
    public $phone;
    public $address;
    public $bio;
    public $avatar;
    public $cover_photo;
    public $newAvatar;
    public $newCoverPhoto;

    // Password fields
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public $showPasswordForm = false;
    public $successMessage = '';
    public $errorMessage = '';
    public $showFullBio = false;

    public function mount()
    {
        $this->user = Auth::user();
        $this->employeeData = $this->user->employeeProfile;
        $this->status = $this->user->status;

        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
        $this->address = $this->user->address;
        $this->bio = $this->user->bio;
        $this->avatar = $this->user->avatar;
        $this->cover_photo = $this->user->cover_photo;
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:5000',
            'newAvatar' => 'nullable|image|max:2048',
            'newCoverPhoto' => 'nullable|image|max:5120',
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Full name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already taken.',
            'newAvatar.image' => 'Profile picture must be an image.',
            'newAvatar.max' => 'Profile picture must not exceed 2MB.',
            'newCoverPhoto.image' => 'Cover photo must be an image.',
            'newCoverPhoto.max' => 'Cover photo must not exceed 5MB.',
        ];
    }

    public function updated($field)
    {
        switch ($field) {
            case 'name':
                $this->name = trim(strip_tags($this->name));
                break;
            case 'email':
                $this->email = strtolower(trim($this->email));
                break;
            case 'phone':
                $this->phone = preg_replace('/[^0-9+]/', '', trim($this->phone));
                break;
            case 'address':
                $this->address = trim(strip_tags($this->address));
                break;
            case 'bio':
                $this->bio = strip_tags($this->bio, '<br><p><strong><em><u><ul><li><ol>');
                break;
        }
    }

    public function updatedNewAvatar(): void
    {
        $this->validateOnly('newAvatar');

        try {
            if ($this->user->avatar) {
                Storage::disk('public')->delete($this->user->avatar);
            }

            $path = $this->newAvatar->store('avatars', 'public');

            $this->user->update(['avatar' => $path]);

            $this->avatar = $path;
            $this->newAvatar = null;

            $this->successMessage = 'Profile picture updated successfully!';
            $this->errorMessage = '';
        } catch (\Exception $e) {
            Log::error('Error uploading avatar', ['error' => $e->getMessage(), 'user_id' => $this->user->id]);
            $this->errorMessage = 'Failed to upload profile picture. Please try again.';
            $this->successMessage = '';
        }
    }

    public function updatedNewCoverPhoto(): void
    {
        $this->validateOnly('newCoverPhoto');

        try {
            if ($this->user->cover_photo) {
                Storage::disk('public')->delete($this->user->cover_photo);
            }

            $path = $this->newCoverPhoto->store('cover_photos', 'public');

            $this->user->update(['cover_photo' => $path]);

            $this->cover_photo = $path;
            $this->newCoverPhoto = null;

            $this->successMessage = 'Cover photo updated successfully!';
            $this->errorMessage = '';
        } catch (\Exception $e) {
            Log::error('Error uploading cover photo', ['error' => $e->getMessage(), 'user_id' => $this->user->id]);
            $this->errorMessage = 'Failed to upload cover photo. Please try again.';
            $this->successMessage = '';
        }
    }

    public function updateProfile()
    {
        $this->validate();

        try {
            $this->user->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone ?: null,
                'address' => $this->address ?: null,
                'bio' => $this->bio ?: null,
            ]);

            $this->successMessage = 'Profile updated successfully!';
            $this->errorMessage = '';

            $this->user = $this->user->fresh();
            $this->status = $this->user->status;
        } catch (\Exception $e) {
            Log::error('Error updating profile', ['error' => $e->getMessage(), 'user_id' => $this->user->id]);
            $this->errorMessage = 'Failed to update profile. Please try again.';
            $this->successMessage = '';
        }
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
            'new_password_confirmation' => 'required|string|min:8',
        ]);

        if (!Hash::check($this->current_password, $this->user->password)) {
            $this->errorMessage = 'Current password is incorrect.';
            $this->successMessage = '';
            return;
        }

        try {
            $this->user->update(['password' => Hash::make($this->new_password)]);

            $this->current_password = '';
            $this->new_password = '';
            $this->new_password_confirmation = '';
            $this->showPasswordForm = false;

            $this->successMessage = 'Password updated successfully!';
            $this->errorMessage = '';
        } catch (\Exception $e) {
            Log::error('Error updating password', ['error' => $e->getMessage(), 'user_id' => $this->user->id]);
            $this->errorMessage = 'Failed to update password. Please try again.';
            $this->successMessage = '';
        }
    }

    public function togglePasswordForm()
    {
        $this->showPasswordForm = !$this->showPasswordForm;
        if (!$this->showPasswordForm) {
            $this->current_password = '';
            $this->new_password = '';
            $this->new_password_confirmation = '';
        }
    }

    public function removeAvatar()
    {
        if (!$this->user->avatar) {
            return;
        }

        try {
            Storage::disk('public')->delete($this->user->avatar);
            $this->user->update(['avatar' => null]);
            $this->avatar = null;

            $this->successMessage = 'Profile picture removed successfully!';
            $this->errorMessage = '';
        } catch (\Exception $e) {
            Log::error('Error removing avatar', ['error' => $e->getMessage(), 'user_id' => $this->user->id]);
            $this->errorMessage = 'Failed to remove profile picture.';
            $this->successMessage = '';
        }
    }

    public function removeCoverPhoto()
    {
        if (!$this->user->cover_photo) {
            return;
        }

        try {
            Storage::disk('public')->delete($this->user->cover_photo);
            $this->user->update(['cover_photo' => null]);
            $this->cover_photo = null;

            $this->successMessage = 'Cover photo removed successfully!';
            $this->errorMessage = '';
        } catch (\Exception $e) {
            Log::error('Error removing cover photo', ['error' => $e->getMessage(), 'user_id' => $this->user->id]);
            $this->errorMessage = 'Failed to remove cover photo.';
            $this->successMessage = '';
        }
    }

    public function toggleBio()
    {
        $this->showFullBio = !$this->showFullBio;
    }
};
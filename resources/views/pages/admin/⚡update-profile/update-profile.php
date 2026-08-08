<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public $admin;

    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $address = '';
    public string $bio = '';
    public $avatar = null;
    public ?string $existingAvatar = null;

    public string $newPassword = '';
    public string $newPasswordConfirmation = '';

    public function mount(): void
    {
        $this->admin = Auth::user();
        $this->name = $this->admin->name;
        $this->email = $this->admin->email;
        $this->phone = $this->admin->phone ?? '';
        $this->address = $this->admin->address ?? '';
        $this->bio = $this->admin->bio ?? '';
        $this->existingAvatar = $this->admin->avatar;
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:100',
            'email' => ['required', 'email:rfc,dns', 'max:255', Rule::unique('users', 'email')->ignore($this->admin->id)],
            'phone' => 'nullable|string|max:11|min:11',
            'address' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|max:2048',
            'newPassword' => 'nullable|string|min:6',
            'newPasswordConfirmation' => 'nullable|string|same:newPassword',
        ];
    }

    protected function sanitizeString(string $value): string
    {
        $value = strip_tags($value);
        $value = str_replace("\0", '', $value);
        $value = preg_replace('/\s+/', ' ', $value);
        return trim($value);
    }

    public function updateProfile(): void
    {
        $this->name = $this->sanitizeString($this->name);
        $this->email = strtolower(trim(filter_var($this->email, FILTER_SANITIZE_EMAIL) ?: ''));
        $this->phone = $this->sanitizeString($this->phone);
        $this->address = $this->sanitizeString($this->address);
        $this->bio = $this->sanitizeString($this->bio);

        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone ?: null,
            'address' => $this->address ?: null,
            'bio' => $this->bio ?: null,
        ];

        if ($this->avatar) {
            if ($this->admin->avatar) {
                Storage::disk('public')->delete($this->admin->avatar);
            }
            $data['avatar'] = $this->avatar->store('avatars', 'public');
        }

        if ($this->newPassword) {
            $data['password'] = Hash::make($this->newPassword);
        }

        $this->admin->update($data);

        session()->flash('success', 'Profile updated successfully!');
        $this->redirectRoute('admin.profile', navigate: true);
    }
};
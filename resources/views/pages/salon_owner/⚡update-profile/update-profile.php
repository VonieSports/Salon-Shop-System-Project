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

    public $tenant_name;
    public $tenant_phone;
    public $tenant_email;
    public $tenant_address;
    public $tenant_logo;

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
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => 'nullable|min:8|confirmed',
            'tenant_name' => 'nullable|string|max:255',
            'tenant_phone' => 'nullable|string|max:11|min:11',
            'tenant_address' => 'nullable|string|max:500',
            'tenant_logo' => 'nullable|image|max:2048',
        ];

        if ($tenant) {
            $rules['tenant_email'] = "nullable|email|unique:tenants,email,{$tenant->id}";
        } else {
            $rules['tenant_email'] = 'nullable|email';
        }

        return $rules;
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
                $user->update(['avatar' => $this->avatar->store('avatars', 'public')]);
            }

            if ($tenant) {
                $tenant->update([
                    'name' => $this->tenant_name,
                    'phone' => $this->tenant_phone,
                    'email' => $this->tenant_email,
                    'address' => $this->tenant_address,
                ]);

                if ($this->tenant_logo) {
                    if ($tenant->logo) {
                        Storage::disk('public')->delete($tenant->logo);
                    }
                    $tenant->update(['logo' => $this->tenant_logo->store('tenant-logos', 'public')]);
                }
            }
        });

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        $this->user = Auth::user()->load('tenant');
        $this->tenant = $this->user->tenant;
        
        session()->flash('success', 'Profile updated successfully!');
    }
};
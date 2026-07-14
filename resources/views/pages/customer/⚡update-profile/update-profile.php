<?php

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

new #[Layout('layouts.customer')] class extends Component
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

    public $customer_gender;
    public $customer_notes;

    public $user;
    public $customer;

    public function mount()
    {
        $this->user = Auth::user();
        $this->customer = $this->user->customerProfile;

        $this->user_name = $this->user->name;
        $this->user_email = $this->user->email;
        $this->user_phone = $this->user->phone;
        $this->user_address = $this->user->address;
        $this->user_bio = $this->user->bio;

        if ($this->customer) {
            $this->customer_gender = $this->customer->gender;
            $this->customer_notes = $this->customer->notes;
        }
    }

    protected function rules()
    {
        $user = Auth::user();

        return [
            'user_name' => 'required|string|max:255',
            'user_email' => "required|email|unique:users,email,{$user->id}",
            'user_phone' => "nullable|string|max:11|min:11|unique:users,phone,{$user->id}",
            'user_address' => 'nullable|string|max:500',
            'user_bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|max:2048',
            'current_password' => 'nullable|required_with:new_password|current_password',
            'new_password' => 'nullable|min:8|confirmed',
            'customer_gender' => 'nullable|string|in:Male,Female,Other',
            'customer_notes' => 'nullable|string|max:500',
        ];
    }

    public function updateProfile()
    {
        $this->validate();

        DB::transaction(function () {
            $user = Auth::user();

            $user->update([
                'name' => $this->user_name,
                'email' => $this->user_email,
                'phone' => $this->user_phone,
                'address' => $this->user_address,
                'bio' => $this->user_bio,
            ]);

            if ($this->new_password) {
                $user->update([
                    'password' => Hash::make($this->new_password)
                ]);
            }

            if ($this->avatar) {
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $user->update([
                    'avatar' => $this->avatar->store('avatars', 'public')
                ]);
            }

            if ($this->customer) {
                $this->customer->update([
                    'gender' => $this->customer_gender,
                    'notes' => $this->customer_notes,
                ]);
            }
        });

        $this->reset(['current_password', 'new_password', 'new_password_confirmation', 'avatar']);
        $this->user = Auth::user()->load('customerProfile');
        $this->customer = $this->user->customerProfile;

        session()->flash('success', 'Profile updated successfully!');
    }   
};
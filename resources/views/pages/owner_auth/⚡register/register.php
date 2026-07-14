<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

new class extends Component
{

    public string $name                  = '';
    public string $email                 = '';
    public string $password              = '';
    public string $password_confirmation = '';
    public bool   $showPassword          = false;
    public bool   $showConfirm           = false;
 
    protected function rules(): array
    {
        return [
            'name'                  => 'required|string|min:2|max:100',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string',
        ];
    }
 
    protected array $messages = [
        'name.required'                  => 'Full name is required.',
        'name.min'                       => 'Name must be at least 2 characters.',
        'email.required'                 => 'Email address is required.',
        'email.email'                    => 'Enter a valid email address.',
        'email.unique'                   => 'This email is already registered.',
        'password.required'              => 'Password is required.',
        'password.min'                   => 'Password must be at least 8 characters.',
        'password.confirmed'             => 'Passwords do not match.',
        'password_confirmation.required' => 'Please confirm your password.',
    ];
 
    public function updated($field): void
    {
        $this->validateOnly($field);
    }
 
    public function register()
    {
        $this->validate();
 
        $user = User::create([
            'name'      => trim($this->name),
            'email'     => strtolower(trim($this->email)),
            'password'  => Hash::make($this->password),
            'is_active' => true,
        ]);
 
        $user->assignRole('owner');
 
        Auth::login($user);
        session()->regenerate();
 
        $user->update(['last_login_at' => now()]);
 
        return redirect()->route('owner.dashboard');
    }
};
<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public string $email    = '';
    public string $password = '';
    public bool   $remember = false;

    protected array $rules = [
        'email'    => 'required|email',
        'password' => 'required|string|min:6',
    ]; 

    protected array $messages = [
        'email.required'    => 'Email is required.',
        'email.email'       => 'Enter a valid email address.',
        'email.unique'      => 'This email is already in use.',
        'password.required' => 'Password is required.',
        'password.incorrect' => 'The provided password is incorrect.',
        'password.min'      => 'Password must be at least 6 characters.',
    ];

    public function login()
    {
        $this->validate();

        if (Auth::attempt(
            ['email' => $this->email, 'password' => $this->password],
            $this->remember
        )) {
            session()->regenerate();

            $user = Auth::user();

            if (! $user->hasRole('owner')) {
                Auth::logout();
                $this->addError('email', 'This portal is for shop owners only.');
                return;
            }

            // Update login metadata
            $user->update([
                'is_active'    => true,
                'last_login_at' => now(),
            ]);

            return redirect()->route('owner.dashboard');
        }

        $this->addError('email', 'Invalid email or password.');
    }

};
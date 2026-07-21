<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
     public string $email = '';
    public string $password = '';
    public bool $remember = false;

    protected array $rules = [
        'email' => 'required|email',
        'password' => 'required|string|min:8',
    ];

    protected array $messages = [
        'email.required' => 'Email is required.',
        'email.email' => 'Enter a valid email address.',
        'password.required' => 'Password is required.',
        'password.min' => 'Password must be at least 8 characters.',
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

            // Check if user is active - owners can never be deactivated
            if (!$user->is_active && !$user->hasRole('owner')) {
                Auth::logout();
                $this->addError('email', 'Your account has been deactivated. Please contact your administrator.');
                return;
            }

            // If owner is inactive, reactivate them automatically
            if ($user->hasRole('owner') && !$user->is_active) {
                $user->update(['is_active' => true]);
            }

            // Update login metadata
            $user->update([
                'last_login_at' => now(),
                'last_logout_at' => null,
            ]);

            // Redirect based on role
            if ($user->hasRole('owner')) {
                return redirect()->route('owner.dashboard');
            } elseif ($user->hasRole('employee')) {
                $employee = $user->employeeProfile;
                if (!$employee || !$employee->tenant_id) {
                    Auth::logout();
                    $this->addError('email', 'Employee account is not properly configured.');
                    return;
                }
                return redirect()->route('employee.dashboard');
            }

            Auth::logout();
            $this->addError('email', 'Account role not recognized.');
            return;
        }

        $this->addError('email', 'Invalid email or password.');
    }
};
<?php

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts.salon_owner')] class extends Component
{
        use WithFileUploads;

    public $name;
    public $email;
    public $phone;
    public $address;
    public $position;
    public $avatar;
    public $password;
    public $password_confirmation;
    public $tenantId;

    public function mount(): void
    {
        $tenant = Auth::user()->tenant;
        abort_unless($tenant?->business_setup_completed, 403, 'Please complete your business setup first.');
        
        $this->tenantId = $tenant->id;
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => 'nullable|string|max:11|min:11|unique:users,phone',
            'address' => 'nullable|string|max:500',
            'position' => 'required|string|max:255',
            'avatar' => 'nullable|image|max:2048',
            'password' => 'required|min:8|confirmed',
        ];
    }

    protected function messages(): array
    {
        return [
            'email.unique' => 'This email is already registered.',
            'phone.unique' => 'This phone number is already registered.',
            'phone.min' => 'Phone number must be exactly 11 digits.',
            'phone.max' => 'Phone number must be exactly 11 digits.',
            'password.required' => 'Password is required for new employee accounts.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters.',
            'avatar.image' => 'The file must be an image.',
            'avatar.max' => 'The image must not be larger than 2MB.',
        ];
    }

    public function updated($field)
    {
        // Sanitize inputs
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
            case 'position':
                $this->position = trim(strip_tags($this->position));
                break;
        }
    }

    public function save(): void
    {
        // Sanitize all inputs before validation
        $this->name = trim(strip_tags($this->name));
        $this->email = strtolower(trim($this->email));
        $this->phone = preg_replace('/[^0-9+]/', '', trim($this->phone));
        $this->address = trim(strip_tags($this->address));
        $this->position = trim(strip_tags($this->position));

        $this->validate();

        try {
            DB::transaction(function () {
                $avatarPath = null;
                
                // Handle avatar upload
                if ($this->avatar) {
                    $avatarPath = $this->avatar->store('avatars', 'public');
                }

                $user = User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'address' => $this->address,
                    'avatar' => $avatarPath,
                    'password' => Hash::make($this->password),
                    'is_active' => true,
                ]);

                $user->assignRole('employee');

                Employee::create([
                    'tenant_id' => $this->tenantId,
                    'user_id' => $user->id,
                    'position' => $this->position,
                    'commission_rate' => 0,
                    'hired_at' => now(),
                    'is_active' => true,
                ]);
            });

            session()->flash('message', 'Employee created successfully! They can now login.');
            $this->redirectRoute('owner.employee', navigate: true);

        } catch (\Exception $e) {
            Log::error('Error creating employee', [
                'error' => $e->getMessage(),
                'tenant_id' => $this->tenantId
            ]);
            session()->flash('error', 'Failed to create employee: ' . $e->getMessage());
        }
    }
};
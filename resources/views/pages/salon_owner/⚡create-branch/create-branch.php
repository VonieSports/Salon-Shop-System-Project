<?php

namespace App\Livewire\Owner;

use App\Models\Tenant;
use App\Models\User;
use App\Models\TenantUser;
use App\Traits\RequiresTenant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

new #[Layout('layouts.salon_owner')] class extends Component
{
    use WithFileUploads, RequiresTenant;

    public string $branchName = '';
    public string $branchEmail = '';
    public string $branchPhone = '';
    public string $branchAddress = '';
    public string $branchType = '';
    public string $branchDescription = '';
    public $branchLogo = null;

    public string $managerName = '';
    public string $managerEmail = '';
    public string $managerPassword = '';
    public string $managerPasswordConfirmation = '';

    public bool $showPassword = false;
    public bool $showConfirmPassword = false;

    public bool $showUnauthorizedModal = false;

    protected ?Tenant $hqTenant = null;

    protected function rules(): array
    {
        return [
            'branchName' => 'required|string|min:2|max:255|unique:tenants,name',
            'branchEmail' => 'required|email:rfc,dns|max:255|unique:tenants,email',
            'branchPhone' => 'required|string|min:10|max:15|regex:/^\+?[0-9]+$/',
            'branchAddress' => 'required|string|min:5|max:500',
            'branchType' => 'nullable|string|max:100',
            'branchDescription' => 'nullable|string|max:1000',
            'branchLogo' => 'nullable|image|max:2048',

            'managerName' => 'required|string|min:2|max:100',
            'managerEmail' => 'required|email:rfc,dns|max:255|unique:users,email',

            'managerPassword' => ['required', 'string', 'min:8'],
            'managerPasswordConfirmation' => ['required', 'string', 'same:managerPassword'],
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'managerPassword' => 'Password',
            'managerPasswordConfirmation' => 'Confirm Password',
        ];
    }

    protected function messages(): array
    {
        return [
            'branchName.required' => 'Branch name is required.',
            'branchName.unique' => 'A branch with this name already exists.',
            'branchEmail.required' => 'Branch email is required.',
            'branchEmail.email' => 'Please enter a valid branch email address.',
            'branchEmail.unique' => 'This email is already registered to another branch.',
            'branchPhone.required' => 'Branch phone number is required.',
            'branchPhone.regex' => 'Please enter a valid phone number.',
            'branchAddress.required' => 'Branch address is required.',
            'managerName.required' => 'Manager name is required.',
            'managerEmail.required' => 'Manager email is required.',
            'managerEmail.unique' => 'This email is already registered.',
            'managerPasswordConfirmation.same' => 'Password confirmation does not match.',
        ];
    }

    protected function sanitizeString(string $value): string
    {
        $value = strip_tags($value);
        $value = str_replace("\0", '', $value);
        $value = preg_replace('/\s+/', ' ', $value);
        return trim($value);
    }

    protected function sanitizeEmail(string $value): string
    {
        return strtolower(trim(filter_var($value, FILTER_SANITIZE_EMAIL) ?: ''));
    }

    protected function sanitizePhone(string $value): string
    {
        return preg_replace('/[^\d+]/', '', trim($value)) ?? '';
    }

    protected function sanitizeAll(): void
    {
        $this->branchName = $this->sanitizeString($this->branchName);
        $this->branchEmail = $this->sanitizeEmail($this->branchEmail);
        $this->branchPhone = $this->sanitizePhone($this->branchPhone);
        $this->branchAddress = $this->sanitizeString($this->branchAddress);
        $this->branchType = $this->sanitizeString($this->branchType);
        $this->branchDescription = $this->sanitizeString($this->branchDescription);
        $this->managerName = $this->sanitizeString($this->managerName);
        $this->managerEmail = $this->sanitizeEmail($this->managerEmail);
    }

    protected function resolveHqTenant(): ?Tenant
    {
        if ($this->hqTenant !== null) {
            return $this->hqTenant;
        }

        $tenant = $this->getTenant();

        if ($tenant && $tenant->isMainTenant()) {
            $this->hqTenant = $tenant;
        }

        return $this->hqTenant;
    }

    protected function canCreateBranch(): bool
    {
        return $this->resolveHqTenant() !== null;
    }

    public function mount(): void
    {
        if (!$this->canCreateBranch()) {
            $this->showUnauthorizedModal = true;
        }
    }

    public function goToDashboard(): void
    {
        $this->redirectRoute('owner.dashboard');
    }

    public function togglePassword(): void
    {
        $this->showPassword = !$this->showPassword;
    }

    public function toggleConfirmPassword(): void
    {
        $this->showConfirmPassword = !$this->showConfirmPassword;
    }

    public function registerBranch(): void
    {

        $hqTenant = $this->resolveHqTenant();

        if ($hqTenant === null) {
            $this->showUnauthorizedModal = true;
            return;
        }

        $this->sanitizeAll();
        $this->validate();

        $currentUser = Auth::user();
        $slug = Str::slug($this->branchName) . '-' . Str::lower(Str::random(5));
        $logoPath = null;

        if ($this->branchLogo) {
            $logoPath = $this->branchLogo->store('branch-logos', 'public');
        }

        DB::beginTransaction();
        try {
            $manager = User::create([
                'name' => $this->managerName,
                'email' => $this->managerEmail,
                'password' => Hash::make($this->managerPassword),
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            $ownerRole = Role::firstOrCreate(['name' => 'owner', 'guard_name' => 'web']);
            $manager->syncRoles([$ownerRole]);

            $branch = Tenant::create([
                'user_id' => $manager->id,
                'parent_tenant_id' => $hqTenant->id,
                'name' => $this->branchName,
                'slug' => $slug,
                'email' => $this->branchEmail,
                'phone' => $this->branchPhone,
                'address' => $this->branchAddress,
                'business_type' => $this->branchType,
                'description' => $this->branchDescription,
                'logo' => $logoPath,
                'business_hours' => null,
                'is_active' => true,
                'verification_status' => 'pending',
                'business_setup_completed' => true,
                'submitted_at' => now(),
            ]);

            TenantUser::firstOrCreate([
                'tenant_id' => $branch->id,
                'user_id' => $manager->id,
            ], ['role' => 'owner']);

            DB::commit();

            session()->flash('success', "Branch '{$branch->name}' has been created and submitted for admin approval!");

            $this->reset([
                'branchName', 'branchEmail', 'branchPhone', 'branchAddress', 'branchType', 'branchDescription', 'branchLogo',
                'managerName', 'managerEmail', 'managerPassword', 'managerPasswordConfirmation',
            ]);

            $this->redirectRoute('owner.branch_table');

        } catch (\Throwable $e) {
            DB::rollBack();

            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }

            Log::error('Branch creation failed: ' . $e->getMessage());
            session()->flash('error', 'Failed to create branch. Please try again.');
        }
    }
};
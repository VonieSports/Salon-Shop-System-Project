<?php

use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts.salon_owner')] class extends Component
{
    use WithFileUploads;

    public $employeeId;
    public ?Employee $employee = null;
    public ?int $tenantId = null;

    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $address = '';
    public string $bio = '';
    public $avatar = null;
    public ?string $existingAvatar = null;

    public string $newPassword = '';
    public string $newPasswordConfirmation = '';

    public string $position = '';
    public ?string $hiredAt = null;
    public float $commissionRate = 0;
    public bool $isCommissionEligible = false;
    public bool $isActive = true;

    public function mount($id): void
    {
        $tenant = Auth::user()->tenant;
        abort_unless($tenant?->business_setup_completed, 403, 'Please complete your business setup first.');

        $this->tenantId = $tenant->id;
        $this->employeeId = (int) $id;

        $record = Employee::with('user')
            ->where('tenant_id', $this->tenantId)
            ->where('id', $this->employeeId)
            ->firstOrFail();

        if ($record->user && $record->user->hasRole('owner')) {
            session()->flash('error', 'Cannot edit a shop owner through this page.');
            $this->redirectRoute('owner.employees');
            return;
        }

        $this->employee = $record;
        $this->loadFromRecord();
    }

    protected function loadFromRecord(): void
    {
        $user = $this->employee->user;

        $this->name = $user?->name ?? '';
        $this->email = $user?->email ?? '';
        $this->phone = $user?->phone ?? '';
        $this->address = $user?->address ?? '';
        $this->bio = $user?->bio ?? '';
        $this->existingAvatar = $user?->avatar;

        $this->position = $this->employee->position ?? '';
        $this->hiredAt = $this->employee->hired_at?->format('Y-m-d');
        $this->commissionRate = (float) ($this->employee->commission_rate ?? 0);
        $this->isCommissionEligible = (bool) ($this->employee->is_commission_eligible ?? false);
        $this->isActive = (bool) $this->employee->is_active;
    }

    protected function rules(): array
    {
        $userId = $this->employee?->user?->id;

        return [
            'name' => 'required|string|min:2|max:100',
            'email' => ['required', 'email:rfc,dns', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'phone' => 'nullable|string|max:11|min:11',
            'address' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|max:2048',

            'newPassword' => 'nullable|string|min:8',
            'newPasswordConfirmation' => 'nullable|string|same:newPassword',

            'position' => 'required|string|max:100',
            'hiredAt' => 'nullable|date',
            'commissionRate' => 'nullable|numeric|min:0|max:100',
            'isCommissionEligible' => 'boolean',
            'isActive' => 'boolean',
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'newPassword' => 'New Password',
            'newPasswordConfirmation' => 'Confirm New Password',
        ];
    }

    protected function sanitizeString(string $value): string
    {
        $value = strip_tags($value);
        $value = str_replace("\0", '', $value);
        $value = preg_replace('/\s+/', ' ', $value);
        return trim($value);
    }

    protected function sanitizeAll(): void
    {
        $this->name = $this->sanitizeString($this->name);
        $this->email = strtolower(trim(filter_var($this->email, FILTER_SANITIZE_EMAIL) ?: ''));
        $this->phone = $this->sanitizeString($this->phone);
        $this->address = $this->sanitizeString($this->address);
        $this->bio = $this->sanitizeString($this->bio);
        $this->position = $this->sanitizeString($this->position);
    }

    public function updateEmployee(): void
    {
        $this->sanitizeAll();
        $this->validate();

        $employee = Employee::with('user')
            ->where('tenant_id', $this->tenantId)
            ->where('id', $this->employeeId)
            ->firstOrFail();

        if ($employee->user && $employee->user->hasRole('owner')) {
            session()->flash('error', 'Cannot edit a shop owner through this page.');
            return;
        }

        DB::beginTransaction();
        try {
            $userData = [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone ?: null,
                'address' => $this->address ?: null,
                'bio' => $this->bio ?: null,
                'is_active' => $this->isActive,
            ];

            if ($this->avatar) {
                if ($employee->user?->avatar) {
                    Storage::disk('public')->delete($employee->user->avatar);
                }
                $userData['avatar'] = $this->avatar->store('avatars', 'public');
            }

            if ($this->newPassword) {
                $userData['password'] = Hash::make($this->newPassword);
            }

            $employee->user?->update($userData);

            $employee->update([
                'position' => $this->position,
                'hired_at' => $this->hiredAt,
                'commission_rate' => $this->commissionRate,
                'is_commission_eligible' => $this->isCommissionEligible,
                'is_active' => $this->isActive,
            ]);

            DB::commit();

            session()->flash('message', 'Employee updated successfully!');
            $this->redirectRoute('owner.employee');

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Employee update failed', [
                'error' => $e->getMessage(),
                'employee_id' => $this->employeeId,
                'tenant_id' => $this->tenantId,
            ]);
            session()->flash('error', 'Failed to update employee. Please try again.');
        }
    }
};
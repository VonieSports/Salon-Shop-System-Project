<?php

namespace App\Livewire\Owner;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Traits\RequiresTenant; // <--- USE THIS TRAIT HERE

new #[Layout('layouts.salon_owner')] class extends Component
{
    use WithFileUploads, RequiresTenant;

    public $tenant;
    public $business_name;
    public $business_email;
    public $business_phone;
    public $business_address;
    public $business_type;
    public $description;
    public $business_logo;
    public $existing_logo;
    public $is_setup_complete = false;
    public $is_editing = false;
    public $business_hours = [];
    public $activeTab = 'info';
    public $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

    public function mount()
    {
        $user = Auth::user();
        
        // CRITICAL: Use $this->getTenant() from the trait
        // This works for Main Owners AND Branch Managers (via pivot table)
        $this->tenant = $this->getTenant();
        
        // If still no tenant found via trait, check pivot table directly just in case
        if (!$this->tenant) {
            $this->tenant = $user->tenantsWithAccess()
                ->wherePivotIn('role', ['owner', 'admin'])
                ->first();
        }
        
        // If still no tenant found, block access
        if (!$this->tenant) {
            return redirect()->route('owner.dashboard');
        }

        if ($this->tenant->business_setup_completed) {
            $this->loadBusinessData();
            $this->is_setup_complete = true;
            $this->is_editing = false;
        } else {
            $this->resetForm();
            $this->is_setup_complete = false;
            $this->is_editing = true;
        }
    }

    protected function loadBusinessData()
    {
        $this->business_name = $this->tenant->name;
        $this->business_email = $this->tenant->email;
        $this->business_phone = $this->tenant->phone;
        $this->business_address = $this->tenant->address;
        $this->business_type = $this->tenant->business_type;
        $this->description = $this->tenant->description;
        $this->existing_logo = $this->tenant->logo;
        $this->business_hours = $this->tenant->business_hours ?? [];
    }

    protected function resetForm()
    {
        $this->business_name = null;
        $this->business_email = null;
        $this->business_phone = null;
        $this->business_address = null;
        $this->business_type = null;
        $this->description = null;
        $this->existing_logo = null;
        $this->business_hours = [];
        $this->business_logo = null;
    }

    protected function rules()
    {
        $tenantId = $this->tenant?->id;

        if (!$this->is_setup_complete) {
            return [
                'business_name' => 'required|string|max:255',
                'business_email' => 'required|email|unique:tenants,email,' . $tenantId,
                'business_phone' => 'required|string|max:20',
                'business_address' => 'required|string|max:500',
                'business_type' => 'required|string|max:100',
                'description' => 'nullable|string|max:1000',
                'business_logo' => 'nullable|image|max:2048',
                'business_hours.*.open' => 'nullable|string',
                'business_hours.*.close' => 'nullable|string',
            ];
        }

        return [
            'business_name' => 'nullable|string|max:255',
            'business_email' => 'nullable|email|unique:tenants,email,' . $tenantId,
            'business_phone' => 'nullable|string|max:20',
            'business_address' => 'nullable|string|max:500',
            'business_type' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
            'business_logo' => 'nullable|image|max:2048',
            'business_hours.*.open' => 'nullable|string',
            'business_hours.*.close' => 'nullable|string',
        ];
    }

    public function addDay($day)
    {
        if (!isset($this->business_hours[$day])) {
            $this->business_hours[$day] = [
                'open' => '',
                'close' => '',
                'closed' => false,
            ];
        }
    }

    public function removeDay($day)
    {
        if (isset($this->business_hours[$day])) {
            unset($this->business_hours[$day]);
        }
    }

    public function toggleDayClosed($day)
    {
        if (isset($this->business_hours[$day])) {
            $this->business_hours[$day]['closed'] = !($this->business_hours[$day]['closed'] ?? false);
            
            if ($this->business_hours[$day]['closed']) {
                $this->business_hours[$day]['open'] = null;
                $this->business_hours[$day]['close'] = null;
            } else {
                $this->business_hours[$day]['open'] = '';
                $this->business_hours[$day]['close'] = '';
            }
        }
    }

    public function saveBusinessInfo()
{
    $this->validate();

    DB::transaction(function () {
        $hoursToSave = [];
        foreach ($this->business_hours as $day => $hours) {
            if ($hours['open'] || $hours['close'] || $hours['closed']) {
                $hoursToSave[$day] = [
                    'open' => $hours['open'] ?? null,
                    'close' => $hours['close'] ?? null,
                    'closed' => $hours['closed'] ?? false,
                ];
            }
        }

        // Only send the business back to "pending" if this is the first
        // submission or it was previously rejected. An already-approved
        // shop stays approved when the owner just tweaks a detail —
        // routine edits shouldn't force a full re-review.
        $isFirstSubmission = !$this->tenant->business_setup_completed;
        $wasRejected = $this->tenant->verification_status === 'rejected';

        $updateData = [
            'business_hours' => $hoursToSave,
            'business_setup_completed' => true,
        ];

        if ($isFirstSubmission || $wasRejected) {
            $updateData['verification_status'] = 'pending';
            $updateData['rejection_reason'] = null;
            $updateData['submitted_at'] = now();
        }

        if ($this->business_name) $updateData['name'] = $this->business_name;
        if ($this->business_email) $updateData['email'] = $this->business_email;
        if ($this->business_phone) $updateData['phone'] = $this->business_phone;
        if ($this->business_address) $updateData['address'] = $this->business_address;
        if ($this->business_type) $updateData['business_type'] = $this->business_type;
        if ($this->description) $updateData['description'] = $this->description;

        $this->tenant->update($updateData);

        if ($this->business_logo) {
            if ($this->tenant->logo) {
                Storage::disk('public')->delete($this->tenant->logo);
            }
            $logoPath = $this->business_logo->store('tenant-logos', 'public');
            $this->tenant->update(['logo' => $logoPath]);
            $this->existing_logo = $logoPath;
            $this->business_logo = null;
        }

        $this->is_setup_complete = true;
        $this->is_editing = false;
        $this->loadBusinessData();
    });

    $message = ($this->tenant->verification_status === 'pending')
        ? 'Business information submitted for review!'
        : 'Business information updated successfully!';

    session()->flash('success', $message);

    return $this->tenant->verification_status === 'pending'
        ? redirect()->route('owner.business_approval')
        : redirect()->route('owner.business_info');
}
};
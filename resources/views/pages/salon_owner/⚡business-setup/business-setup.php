<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

new #[Layout('layouts.salon_owner')] class extends Component
{
    use WithFileUploads;

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
        $this->tenant = Auth::user()->tenant;
        
        if ($this->tenant) {
            if ($this->tenant->business_setup_completed) {
                $this->loadBusinessData();
                $this->is_setup_complete = true;
                $this->is_editing = false;
            } else {
                $this->resetForm();
                $this->is_setup_complete = false;
                $this->is_editing = true;
            }
        } else {
            return redirect()->route('owner.dashboard');
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

    public function startEditing()
    {
        $this->loadBusinessData();
        $this->is_editing = true;
        $this->business_logo = null;
    }

    public function cancelEdit()
    {
        $this->loadBusinessData();
        $this->is_editing = false;
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
            $user = Auth::user();
            
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

            if (!$this->tenant) {
                $this->tenant = Tenant::create([
                    'user_id' => $user->id,
                    'name' => $this->business_name,
                    'slug' => \Illuminate\Support\Str::slug($this->business_name),
                    'email' => $this->business_email,
                    'phone' => $this->business_phone,
                    'address' => $this->business_address,
                    'business_type' => $this->business_type,
                    'description' => $this->description,
                    'business_hours' => $hoursToSave,
                    'is_active' => true,
                    'business_setup_completed' => true,
                    'verification_status' => 'pending',
                    'submitted_at' => now(),
                ]);
            } else {
                $updateData = [
                    'business_hours' => $hoursToSave,
                    'business_setup_completed' => true,
                    'submitted_at' => now(),
                ];

                // Only update fields that have values
                if ($this->business_name) $updateData['name'] = $this->business_name;
                if ($this->business_email) $updateData['email'] = $this->business_email;
                if ($this->business_phone) $updateData['phone'] = $this->business_phone;
                if ($this->business_address) $updateData['address'] = $this->business_address;
                if ($this->business_type) $updateData['business_type'] = $this->business_type;
                if ($this->description) $updateData['description'] = $this->description;

                $this->tenant->update($updateData);
            }

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

        session()->flash('success', 'Business information saved successfully!');
        return redirect()->route('owner.business_info');
    }
};
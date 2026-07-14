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
    public $business_logo;
    public $existing_logo;
    public $is_setup_complete = false;
    public $is_editing = false;

    public function mount()
    {
        $this->tenant = Auth::user()->tenant;
        
        if ($this->tenant) {
            $this->business_name = $this->tenant->name;
            $this->business_email = $this->tenant->email;
            $this->business_phone = $this->tenant->phone;
            $this->business_address = $this->tenant->address;
            $this->existing_logo = $this->tenant->logo;
            $this->is_setup_complete = $this->tenant->business_setup_completed;
            $this->is_editing = !$this->is_setup_complete;
        } else {
            $this->is_editing = true;
        }
    }

    protected function rules()
    {
        $tenantId = $this->tenant?->id;

        return [
            'business_name' => 'required|string|max:255',
            'business_email' => "nullable|email|unique:tenants,email,{$tenantId}",
            'business_phone' => 'nullable|string|max:11|min:11',
            'business_address' => 'nullable|string|max:500',
            'business_logo' => 'nullable|image|max:2048',
        ];
    }

    public function saveBusinessInfo()
    {
        $this->validate();

        DB::transaction(function () {
            $user = Auth::user();
            
            if (!$this->tenant) {
                $this->tenant = Tenant::create([
                    'user_id' => $user->id,
                    'name' => $this->business_name,
                    'slug' => \Illuminate\Support\Str::slug($this->business_name),
                    'email' => $this->business_email,
                    'phone' => $this->business_phone,
                    'address' => $this->business_address,
                    'is_active' => true,
                    'business_setup_completed' => true,
                    'verification_status' => 'pending',
                    'submitted_at' => now(),
                ]);
            } else {
                $this->tenant->update([
                    'name' => $this->business_name,
                    'email' => $this->business_email,
                    'phone' => $this->business_phone,
                    'address' => $this->business_address,
                    'business_setup_completed' => true,
                    'submitted_at' => now(),
                ]);
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
        });

        session()->flash('success', 'Business information saved successfully!');
        return redirect()->route('owner.business_info');
    }

    public function cancelEdit()
    {
        if ($this->tenant) {
            $this->business_name = $this->tenant->name;
            $this->business_email = $this->tenant->email;
            $this->business_phone = $this->tenant->phone;
            $this->business_address = $this->tenant->address;
            $this->existing_logo = $this->tenant->logo;
        }
        $this->business_logo = null;
        $this->is_editing = false;
        
        return redirect()->route('owner.business_info');
    }
};
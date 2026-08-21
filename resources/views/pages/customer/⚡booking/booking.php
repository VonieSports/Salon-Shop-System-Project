<?php

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use Carbon\Carbon;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.customer')] class extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filter = 'all';
    public string $sort = 'newest';
    
    // Filter properties
    public ?string $dateFilter = null;
    public ?string $statusFilter = null;
    public ?string $shopFilter = null;
    public ?string $serviceFilter = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 'all'],
        'sort' => ['except' => 'newest'],
        'dateFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'shopFilter' => ['except' => ''],
        'serviceFilter' => ['except' => ''],
    ];

    #[Computed]
    public function bookings()
    {
        $query = Appointment::with([
            'service:id,name,image,duration_minutes,price',
            'employee.user:id,name,avatar',
            'post:id,name,image,price,duration_minutes',
            'tenant:id,name,address,phone,logo',
            'customer.user:id,name,avatar'
        ]);

        // Only show public bookings (not cancelled or no-show)
        $query->whereIn('status', [
            AppointmentStatus::QUEUED->value,
            AppointmentStatus::IN_PROGRESS->value,
            AppointmentStatus::COMPLETED->value,
        ]);

        // Apply filters
        $this->applyFilters($query);
        
        // Search
        $this->applySearch($query);
        
        // Sort
        $this->applySort($query);

        return $query->paginate(12);
    }

    #[Computed]
    public function stats()
    {
        return [
            'total' => Appointment::whereIn('status', [
                AppointmentStatus::QUEUED->value,
                AppointmentStatus::IN_PROGRESS->value,
                AppointmentStatus::COMPLETED->value,
            ])->count(),
            'queued' => Appointment::where('status', AppointmentStatus::QUEUED->value)->count(),
            'in_progress' => Appointment::where('status', AppointmentStatus::IN_PROGRESS->value)->count(),
            'completed' => Appointment::where('status', AppointmentStatus::COMPLETED->value)->count(),
        ];
    }

    #[Computed]
    public function shops()
    {
        return Appointment::whereIn('status', [
                AppointmentStatus::QUEUED->value,
                AppointmentStatus::IN_PROGRESS->value,
                AppointmentStatus::COMPLETED->value,
            ])
            ->with('tenant')
            ->get()
            ->pluck('tenant')
            ->unique('id')
            ->filter()
            ->values();
    }

    #[Computed]
    public function services()
    {
        return Appointment::whereIn('status', [
                AppointmentStatus::QUEUED->value,
                AppointmentStatus::IN_PROGRESS->value,
                AppointmentStatus::COMPLETED->value,
            ])
            ->with('service')
            ->get()
            ->pluck('service')
            ->unique('id')
            ->filter()
            ->values();
    }

    protected function applyFilters($query): void
    {
        // Status filter
        if ($this->statusFilter && $this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        // Date filter
        if ($this->dateFilter) {
            $query->whereDate('appointment_date', $this->dateFilter);
        }

        // Shop filter
        if ($this->shopFilter) {
            $query->whereHas('tenant', function($q) {
                $q->where('id', $this->shopFilter);
            });
        }

        // Service filter
        if ($this->serviceFilter) {
            $query->whereHas('service', function($q) {
                $q->where('id', $this->serviceFilter);
            });
        }
    }

    protected function applySearch($query): void
    {
        if ($this->search) {
            $query->where(function($q) {
                $q->whereHas('service', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
                  ->orWhereHas('post', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
                  ->orWhereHas('tenant', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
                  ->orWhereHas('customer.user', fn($q) => $q->where('name', 'like', '%' . $this->search . '%'));
            });
        }
    }

    protected function applySort($query): void
    {
        if ($this->sort === 'newest') {
            $query->orderBy('appointment_date', 'desc')->orderBy('created_at', 'desc');
        } elseif ($this->sort === 'oldest') {
            $query->orderBy('appointment_date', 'asc')->orderBy('created_at', 'asc');
        } elseif ($this->sort === 'price_high') {
            $query->orderBy('service.price', 'desc');
        } elseif ($this->sort === 'price_low') {
            $query->orderBy('service.price', 'asc');
        }
    }

    public function clearFilters(): void
    {
        $this->search = '';
        $this->filter = 'all';
        $this->sort = 'newest';
        $this->dateFilter = null;
        $this->statusFilter = null;
        $this->shopFilter = null;
        $this->serviceFilter = null;
    }

    public function getServiceName($booking): string
    {
        return $booking->service?->name ?? $booking->post?->name ?? 'Service';
    }

    public function getServiceImage($booking): ?string
    {
        return $booking->service?->image ?? $booking->post?->image ?? null;
    }

    public function getServiceDuration($booking): int
    {
        return $booking->service?->duration_minutes ?? $booking->post?->duration_minutes ?? 30;
    }

    public function getServicePrice($booking): float
    {
        return $booking->service?->price ?? $booking->post?->price ?? 0;
    }

    public function getCustomerName($booking): string
    {
        return $booking->customer?->user?->name ?? 'Guest';
    }

};
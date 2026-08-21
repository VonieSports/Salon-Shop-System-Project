<?php

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Post;
use App\Services\AvailabilityService;
use App\Services\BookingService;
use App\Services\ProfileCompletenessService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

new #[Layout('layouts.customer')] class extends Component
{
    public Post $post;

    #[Url] public ?int $employee = null;
    #[Url] public ?string $date = null;

    public string $paymentType = 'cash';

    public function mount(Post $post): void
    {
        abort_unless($post->type === 'service' && $post->status === 'published', 404);

        $post->load(['tenant:id,name,address,phone', 'inventory']);
        $this->post = $post;
        $this->date = $this->date ?: now()->toDateString();
    }

    #[Computed]
    public function selectedEmployee(): ?Employee
    {
        if (!$this->employee) return null;
        return Employee::with('user:id,name,avatar')->find($this->employee);
    }

    #[Computed]
    public function availability()
    {
        return app(AvailabilityService::class)
            ->employeeAvailability($this->post, Carbon::parse($this->date))
            ->firstWhere('employee.id', $this->employee);
    }

    public function confirmBooking(BookingService $bookingService, ProfileCompletenessService $profileCheck)
    {
        if (!$this->selectedEmployee) {
            session()->flash('error', 'Please select a staff member first.');
            return;
        }

        $user = Auth::user();

        if (!$profileCheck->isComplete($user)) {
            session()->flash('warning', 'Please complete your profile (' . implode(', ', $profileCheck->missingFields($user)) . ') before booking a service.');
            return redirect()->route('customer.update_profile');
        }

        $price = (float) ($this->post->price ?? 0);

        try {
            $result = DB::transaction(function () use ($bookingService, $user, $price) {
                $customer = Customer::firstOrCreate(
                    ['tenant_id' => $this->post->tenant_id, 'user_id' => $user->id],
                    ['name' => $user->name, 'email' => $user->email, 'phone' => $user->phone]
                );

                $order = Order::create([
                    'tenant_id' => $this->post->tenant_id,
                    'user_id' => $user->id,
                    'customer_id' => $customer->id,
                    'order_number' => 'SRV-' . strtoupper(Str::random(10)),
                    'type' => 'service',
                    'status' => OrderStatus::PENDING,
                    'payment_status' => PaymentStatus::UNPAID,
                    'payment_type' => $this->paymentType,
                    'subtotal' => $price,
                    'discount' => 0,
                    'tax' => 0,
                    'total' => $price,
                ]);

                $appointment = $bookingService->queue(
                    $this->post,
                    $this->selectedEmployee,
                    $customer->id,
                    Carbon::parse($this->date),
                    $order->id
                );

                OrderItem::create([
                    'tenant_id' => $this->post->tenant_id,
                    'order_id' => $order->id,
                    'service_id' => $this->post->inventory_id,
                    'employee_id' => $this->selectedEmployee->id,
                    'appointment_id' => $appointment->id,
                    'item_type' => 'service',
                    'name' => $this->post->name,
                    'price' => $price,
                    'quantity' => 1,
                    'subtotal' => $price,
                ]);

                return $order;
            });

            if ($this->paymentType === 'online') {
                return redirect()->route('customer.payment.paymongo', $result->id);
            }

            return $this->redirect(route('customer.track_order', $result->id), navigate: true);

        } catch (\Throwable $e) {
            report($e);
            session()->flash('error', 'Failed to book this service. Please try again.');
        }
    }
};
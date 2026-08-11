<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Appointment extends Model
{
    protected $fillable = [
        'tenant_id',
        'customer_id',
        'employee_id',
        'service_id',
        'post_id',
        'order_id',
        'appointment_date',
        'queue_number',
        'status',
        'queued_at',
        'started_at',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'queue_number' => 'integer',
        'status' => AppointmentStatus::class,
        'queued_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'appointment_services')->withPivot('price')->withTimestamps();
    }
}

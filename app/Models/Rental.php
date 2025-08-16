<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\Rental
 *
 * @property int $id
 * @property int $console_id
 * @property int $customer_id
 * @property int|null $rental_package_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $start_time
 * @property \Illuminate\Support\Carbon $end_time
 * @property \Illuminate\Support\Carbon|null $actual_end_time
 * @property float $total_amount
 * @property float $paid_amount
 * @property string $status
 * @property string $payment_status
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Console $console
 * @property-read \App\Models\Customer $customer
 * @property-read \App\Models\RentalPackage|null $rentalPackage
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Sale|null $sale
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FraudDetection> $fraudDetections
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Rental newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rental newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rental query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rental active()
 * @method static \Database\Factories\RentalFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Rental extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'console_id',
        'customer_id',
        'rental_package_id',
        'user_id',
        'start_time',
        'end_time',
        'actual_end_time',
        'total_amount',
        'paid_amount',
        'status',
        'payment_status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'actual_end_time' => 'datetime',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the console for this rental.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function console(): BelongsTo
    {
        return $this->belongsTo(Console::class);
    }

    /**
     * Get the customer for this rental.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the rental package for this rental.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rentalPackage(): BelongsTo
    {
        return $this->belongsTo(RentalPackage::class);
    }

    /**
     * Get the user (cashier) who created this rental.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the sale associated with this rental.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sale(): HasOne
    {
        return $this->hasOne(Sale::class);
    }

    /**
     * Get the fraud detections for this rental.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fraudDetections(): HasMany
    {
        return $this->hasMany(FraudDetection::class);
    }

    /**
     * Scope a query to only include active rentals.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get the remaining time for this rental in seconds.
     *
     * @return int
     */
    public function getRemainingTimeAttribute(): int
    {
        if ($this->status !== 'active') {
            return 0;
        }

        $now = now();
        if ($now > $this->end_time) {
            return 0;
        }

        return (int) $this->end_time->diffInSeconds($now);
    }

    /**
     * Check if the rental is overdue.
     *
     * @return bool
     */
    public function isOverdue(): bool
    {
        return $this->status === 'active' && now() > $this->end_time;
    }
}
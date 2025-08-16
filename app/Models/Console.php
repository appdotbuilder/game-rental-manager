<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Console
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $status
 * @property string $iot_device_id
 * @property bool $is_online
 * @property float $hourly_rate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rental> $rentals
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FraudDetection> $fraudDetections
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Console newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Console newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Console query()
 * @method static \Illuminate\Database\Eloquent\Builder|Console available()
 * @method static \Database\Factories\ConsoleFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Console extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'type',
        'status',
        'iot_device_id',
        'is_online',
        'hourly_rate',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_online' => 'boolean',
        'hourly_rate' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the rentals for this console.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Get the fraud detections for this console.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fraudDetections(): HasMany
    {
        return $this->hasMany(FraudDetection::class);
    }

    /**
     * Scope a query to only include available consoles.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Get the current active rental for this console.
     *
     * @return \App\Models\Rental|null
     */
    public function getCurrentRental(): ?Rental
    {
        /** @var \App\Models\Rental|null */
        return $this->rentals()->where('status', 'active')->first();
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\FraudDetection
 *
 * @property int $id
 * @property int $console_id
 * @property int|null $rental_id
 * @property string $fraud_type
 * @property string $description
 * @property array|null $metadata
 * @property string $severity
 * @property bool $is_resolved
 * @property \Illuminate\Support\Carbon $detected_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Console $console
 * @property-read \App\Models\Rental|null $rental
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|FraudDetection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FraudDetection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FraudDetection query()
 * @method static \Illuminate\Database\Eloquent\Builder|FraudDetection unresolved()
 * @method static \Database\Factories\FraudDetectionFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class FraudDetection extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'console_id',
        'rental_id',
        'fraud_type',
        'description',
        'metadata',
        'severity',
        'is_resolved',
        'detected_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_resolved' => 'boolean',
        'metadata' => 'array',
        'detected_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the console for this fraud detection.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function console(): BelongsTo
    {
        return $this->belongsTo(Console::class);
    }

    /**
     * Get the rental for this fraud detection.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rental(): BelongsTo
    {
        return $this->belongsTo(Rental::class);
    }

    /**
     * Scope a query to only include unresolved fraud detections.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnresolved($query)
    {
        return $query->where('is_resolved', false);
    }
}
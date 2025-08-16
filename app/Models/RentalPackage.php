<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\RentalPackage
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $duration_hours
 * @property float $price
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rental> $rentals
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|RentalPackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RentalPackage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RentalPackage query()
 * @method static \Illuminate\Database\Eloquent\Builder|RentalPackage active()
 * @method static \Database\Factories\RentalPackageFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class RentalPackage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'duration_hours',
        'price',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'duration_hours' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the rentals that use this package.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rentals(): HasMany
    {
        return $this->hasMany(Rental::class);
    }

    /**
     * Scope a query to only include active packages.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
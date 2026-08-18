<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\RegionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * A delivery/order zone (Uzbekistan's regions today). Closed list — seeded by
 * RegionSeeder, not user-creatable. An Offer can deliver to more than one
 * region (its deliverable zones).
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 */
class Region extends Model
{
    /** @use HasFactory<RegionFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Offers that deliver to this region.
     *
     * @return BelongsToMany<Offer, $this>
     */
    public function offers(): BelongsToMany
    {
        return $this->belongsToMany(Offer::class);
    }
}

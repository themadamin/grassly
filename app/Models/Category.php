<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Top level of the crop taxonomy (e.g. Vegetables, Grains). Closed list —
 * seeded by CategorySeeder, not user-creatable.
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 */
class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * The crops grouped under this category.
     *
     * @return HasMany<Crop, $this>
     */
    public function crops(): HasMany
    {
        return $this->hasMany(Crop::class);
    }
}

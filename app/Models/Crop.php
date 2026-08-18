<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\CropFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * The bottom level of the crop taxonomy (e.g. Tomato, under Vegetables).
 * Closed list — seeded by CropSeeder; a Product picks one, no free-typing.
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $slug
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 * @property-read Category $category
 */
class Crop extends Model
{
    /** @use HasFactory<CropFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'slug',
    ];

    /**
     * The category this crop belongs to.
     *
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Products farmers have listed under this crop.
     *
     * @return HasMany<Product, $this>
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}

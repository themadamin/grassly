<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property int $crop_id
 * @property string|null $notes
 * @property int|null $offers_count
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 * @property-read User $farmer
 * @property-read Crop $crop
 */
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    use SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'crop_id',
        'notes',
    ];

    /**
     * The farmer who owns this product.
     *
     * @return BelongsTo<User, $this>
     */
    public function farmer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The seeded crop this product is listed under (closed list — see
     * CropSeeder). Category is reached via `$product->crop->category`.
     *
     * @return BelongsTo<Crop, $this>
     */
    public function crop(): BelongsTo
    {
        return $this->belongsTo(Crop::class);
    }

    /**
     * The sell offers created for this product.
     *
     * NOTE: relies on offers.product_id, which lands with the Offer reshape
     * (Feature 2). Safe to keep — nothing queries it until then.
     *
     * @return HasMany<Offer, $this>
     */
    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }
}

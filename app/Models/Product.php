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
 * @property string $region
 * @property string|null $notes
 * @property int|null $offers_count
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 * @property-read User $farmer
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
        'region',
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

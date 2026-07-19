<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\Currency;
use App\Enums\OfferStatus;
use App\Enums\OfferVisibility;
use Carbon\CarbonImmutable;
use Database\Factories\OfferFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property string $title
 * @property int $total_quantity
 * @property int $remaining_quantity
 * @property string $unit
 * @property float $price
 * @property Currency $currency
 * @property string $region
 * @property CarbonImmutable $available_from
 * @property CarbonImmutable|null $available_to
 * @property string|null $description
 * @property OfferVisibility $visibility
 * @property OfferStatus $status
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 * @property-read Product $product
 * @property-read User $farmer
 */
class Offer extends Model
{
    /** @use HasFactory<OfferFactory> */
    use HasFactory;

    use SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'product_id',
        'user_id',
        'title',
        'total_quantity',
        'remaining_quantity',
        'unit',
        'price',
        'currency',
        'region',
        'available_from',
        'available_to',
        'description',
        'visibility',
        'status',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'available_from' => 'date:Y-m-d',
            'available_to' => 'date:Y-m-d',
            'total_quantity' => 'integer',
            'remaining_quantity' => 'integer',
            // Column holds integer minor units; MoneyCast exposes it as a decimal
            // in `currency`'s units. Cast currency first so it's available to the
            // money conversion.
            'currency' => Currency::class,
            'price' => MoneyCast::class,
            'visibility' => OfferVisibility::class,
            'status' => OfferStatus::class,
        ];
    }

    /**
     * The product this sell campaign is for.
     *
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * The farmer who owns this offer (denormalized from the product).
     *
     * @return BelongsTo<User, $this>
     */
    public function farmer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

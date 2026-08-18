<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\Currency;
use App\Enums\OfferStatus;
use App\Enums\OfferVisibility;
use Carbon\CarbonImmutable;
use Database\Factories\OfferFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
 * @property CarbonImmutable $available_from
 * @property CarbonImmutable|null $available_to
 * @property string|null $description
 * @property OfferVisibility $visibility
 * @property OfferStatus $status
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 * @property-read Product $product
 * @property-read User $farmer
 * @property-read Collection<int, Region> $regions
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
            // currency must cast before price — MoneyCast needs it for the conversion.
            'currency' => Currency::class,
            'price' => MoneyCast::class,
            'visibility' => OfferVisibility::class,
            'status' => OfferStatus::class,
        ];
    }

    /**
     * Base authorization scope for the offer index: an offer belongs to the
     * farmer who owns it (user_id). This is the FIRST step of the filter order
     * (base scope → filters → sort → paginate) and is applied in the controller
     * BEFORE the pipeline — no query param can widen past it, so a farmer can
     * only ever see their own offers regardless of what filters are sent.
     *
     * @param  Builder<Offer>  $query
     */
    public function scopeWhereOwnedBy(Builder $query, User $user): void
    {
        $query->where('user_id', $user->id);
    }

    /**
     * Base scope for the shared Market browse: only offers a farmer has
     * intentionally published (visibility = public) AND that are currently
     * live for sale (status = on_sale) — draft/closed offers never appear,
     * regardless of any Market filter. Same role as whereOwnedBy above: applied
     * BEFORE the filter pipeline, not user-overridable by any query param.
     *
     * @param  Builder<Offer>  $query
     */
    public function scopeOnMarket(Builder $query): void
    {
        $query->where('visibility', OfferVisibility::PUBLIC)
            ->where('status', OfferStatus::ON_SALE);
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

    /**
     * The seeded zones this offer delivers to (closed list — see
     * RegionSeeder). An offer can deliver to more than one region.
     *
     * @return BelongsToMany<Region, $this>
     */
    public function regions(): BelongsToMany
    {
        return $this->belongsToMany(Region::class);
    }
}

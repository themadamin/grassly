<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\Currency;
use App\Enums\OfferStatus;
use Carbon\CarbonImmutable;
use Database\Factories\DemandFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * A Demand is the merchant's buy-offer — the MIRROR of an Offer ("I want to buy
 * X"). Farmers claim against a demand the same way merchants claim against an
 * offer (symmetric — reuse the campaign-detail component on the frontend).
 *
 * Scaffold — mirrors App\Models\Offer. It reuses OfferStatus (draft/on_sale/
 * closed) for now; introduce a dedicated DemandStatus later if the buy side
 * needs a different lifecycle.
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $category
 * @property int $quantity
 * @property int $fulfilled_quantity
 * @property string $unit
 * @property float $price
 * @property Currency $currency
 * @property string $region
 * @property CarbonImmutable|null $needed_by
 * @property string|null $note
 * @property OfferStatus $status
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 * @property-read User $merchant
 */
class Demand extends Model
{
    /** @use HasFactory<DemandFactory> */
    use HasFactory;

    use SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'category',
        'quantity',
        'fulfilled_quantity',
        'unit',
        'price',
        'currency',
        'region',
        'needed_by',
        'note',
        'status',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'needed_by' => 'date:Y-m-d',
            'quantity' => 'integer',
            'fulfilled_quantity' => 'integer',
            'currency' => Currency::class,
            'price' => MoneyCast::class,
            'status' => OfferStatus::class,
        ];
    }

    /**
     * The merchant who posted this buy-offer.
     *
     * @return BelongsTo<User, $this>
     */
    public function merchant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

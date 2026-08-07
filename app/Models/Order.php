<?php

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\Currency;
use App\Enums\OrderStatus;
use Carbon\CarbonImmutable;
use Database\Factories\OrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * An Order is a "claim": a merchant buying PART of an Offer's quantity. Placing
 * one decrements the offer's `remaining_quantity` (that atomic write is your
 * Milestone A.2 learning — see OrderController@store). `price` is a SNAPSHOT of
 * the offer's price at purchase time, so later offer edits don't rewrite history.
 *
 * Scaffold — mirrors App\Models\Offer. Review the fillable/casts/relations as
 * your Milestone A.1 data-layer exercise.
 *
 * @property int $id
 * @property int $offer_id
 * @property int $user_id
 * @property int $quantity
 * @property float $price
 * @property Currency $currency
 * @property OrderStatus $status
 * @property string|null $delivery_window
 * @property string|null $note
 * @property CarbonImmutable $created_at
 * @property CarbonImmutable $updated_at
 * @property-read Offer $offer
 * @property-read User $merchant
 */
class Order extends Model
{
    /** @use HasFactory<OrderFactory> */
    use HasFactory;

    use SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'offer_id',
        'user_id',
        'quantity',
        'price',
        'currency',
        'status',
        'delivery_window',
        'note',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            // Snapshot price: integer minor units in the DB, decimal via MoneyCast.
            'currency' => Currency::class,
            'price' => MoneyCast::class,
            'status' => OrderStatus::class,
        ];
    }

    /**
     * The offer this claim was placed against.
     *
     * @return BelongsTo<Offer, $this>
     */
    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    /**
     * The merchant who placed the claim.
     *
     * @return BelongsTo<User, $this>
     */
    public function merchant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

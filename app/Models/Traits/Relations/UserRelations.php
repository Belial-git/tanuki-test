<?php

declare(strict_types=1);

namespace App\Models\Traits\Relations;

use App\Models\Basket;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Basket $basket
 * @property Order  $order
 */
trait UserRelations
{
    /**
     * @return BelongsTo<Basket, $this>
     */
    public function basket(): BelongsTo
    {
        return $this->belongsTo(Basket::class);
    }

    /**
     * @return BelongsTo<Order, $this>
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}

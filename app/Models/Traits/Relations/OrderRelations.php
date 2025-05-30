<?php

declare(strict_types=1);

namespace App\Models\Traits\Relations;

use App\Models\Basket;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property Basket $basket
 */
trait OrderRelations
{
    /**
     * @return BelongsTo<Basket, $this>
     */
    public function basket(): BelongsTo
    {
        return $this->belongsTo(Basket::class, 'basket_id');
    }
}

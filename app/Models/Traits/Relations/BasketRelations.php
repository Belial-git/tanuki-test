<?php

declare(strict_types=1);

namespace App\Models\Traits\Relations;

use App\Models\Basket;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property User $user
 */
trait BasketRelations
{
    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Basket::class, 'user_id');
    }
}

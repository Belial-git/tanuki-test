<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Attributes\CamelCaseAttributes;
use App\Models\Traits\Relations\BasketRelations;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int               $id
 * @property int|null          $userId
 * @property array<mixed>|null $products
 * @property float|null        $totalPrice
 * @property Carbon|null       $createdAt
 * @property Carbon|null       $updatedAt
 */
class Basket extends Model
{
    use CamelCaseAttributes;
    use BasketRelations;
    use HasFactory;

    protected $fillable = [
        'userId',
        'products',
        'totalPrice',
    ];

    protected $casts = [
        'products' => 'array',
    ];
}

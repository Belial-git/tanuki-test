<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Attributes\CamelCaseAttributes;
use App\Models\Traits\Relations\OrderRelations;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int         $id
 * @property int|null    $userId
 * @property int         $basketId
 * @property string      $address
 * @property string      $phone
 * @property string      $status
 * @property float       $discount
 * @property float       $finalPrice
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 */
class Order extends Model
{
    use CamelCaseAttributes;
    use OrderRelations;
    use HasFactory;

    protected $fillable = [
        'basketId',
        'userId',
        'address',
        'phone',
        'status',
        'discount',
        'finalPrice',
    ];
}

<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Attributes\CamelCaseAttributes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int         $id
 * @property string      $type
 * @property string      $condition
 * @property int|null    $discountSum
 * @property int|null    $discountPercent
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 */
class Discount extends Model
{
    use CamelCaseAttributes;
    use HasFactory;

    protected $fillable = [
        'type',
        'condition',
        'discountSum',
        'discountPercent',
    ];
}

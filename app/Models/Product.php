<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Attributes\CamelCaseAttributes;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int         $id
 * @property string      $title
 * @property string      $description
 * @property float       $price
 * @property bool        $isStopped
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 */
class Product extends Model
{
    use CamelCaseAttributes;
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'isStopped',
    ];
}

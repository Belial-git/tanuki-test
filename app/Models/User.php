<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Attributes\CamelCaseAttributes;
use App\Models\Traits\Relations\UserRelations;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int         $id
 * @property string      $firstName
 * @property string      $lastName
 * @property string|null $patronymic
 * @property string|null $address
 * @property string|null $phone
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 */
class User extends Model
{
    use CamelCaseAttributes;
    use UserRelations;
    use HasFactory;

    protected $fillable = [
        'firstName',
        'lastName',
        'lastName',
        'phone',
        'address',
        'patronymic',
    ];
}

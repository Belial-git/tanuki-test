<?php

declare(strict_types=1);

namespace App\Dto\Request;

use App\Facades\Utils\PhoneNumberNormalizer;
use Closure;
use OpenApi\Attributes as OA;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

#[OA\Schema(schema: 'RequestOrderRequestDto')]
class OrderRequestDto extends Data
{
    #[OA\Property,IntegerType]
    public ?int $userId; // Так как нет регистрации и авторизации передавать любой
    #[OA\Property,IntegerType]
    public ?int $basketId;
    #[OA\Property,StringType]
    public ?string $address;
    #[OA\Property,StringType]
    public ?string $phone;
    #[OA\Property,StringType]
    public ?string $lastName;
    #[OA\Property,StringType]
    public ?string $firstName;
    #[OA\Property,StringType]
    public ?string $patronymic;
    #[OA\Property,StringType]
    public ?string $promoCode;

    /**
     * @return array<string, mixed>
     */
    public static function rules(ValidationContext $context): array
    {
        if (null === ($context->payload['userId'] ?? null)) {
            $rules = [
                'firstName' => ['required', 'string'],
                'lastName' => ['required', 'string'],
                'patronymic' => ['required', 'string'],
                'basketId' => ['required', 'int', 'exists:baskets,id'],
                'address' => ['required', 'string'],
                'phone' => [
                    'required',
                    'string',
                    function (string $attribute, mixed $value, Closure $fail): void {
                        if (!is_string($value)) {
                            $fail(__('validation.regex', ['attribute' => $attribute]));

                            return;
                        }
                        $phone = PhoneNumberNormalizer::normalize($value);
                        if (!$phone) {
                            $fail(__('validation.regex', ['attribute' => $attribute]));
                        }
                    },
                ],
            ];
        } else {
            $rules = [
                'userId' => ['required', 'int', 'exists:users,id'],
            ];
        }

        return $rules;
    }
}

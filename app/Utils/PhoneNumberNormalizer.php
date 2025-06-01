<?php

declare(strict_types=1);

namespace App\Utils;

class PhoneNumberNormalizer
{
    public function normalize(?string $phone): ?string
    {
        if (!$phone) {
            return null;
        }

        $phone = preg_replace('/[^+0-9]/', '', $phone);

        if (!$phone) {
            return null;
        }

        $normalizedPhone = $this->tryNormalizeRussianPhoneNumber($phone);

        if (!$normalizedPhone) {
            $normalizedPhone = $this->tryNormalizeKazakhstanPhoneNumber($phone);
        }

        if (!$normalizedPhone) {
            $normalizedPhone = $this->tryNormalizeUzbekistanPhoneNumber($phone);
        }

        if (!$normalizedPhone) {
            return null;
        }

        return $normalizedPhone;
    }

    private function tryNormalizeRussianPhoneNumber(string $phone): ?string
    {
        if (preg_match('/^7[0-9]{10}$/', $phone)) {
            return "+{$phone}";
        }

        if (preg_match('/^\+7[0-9]{10}$/', $phone)) {
            return $phone;
        }

        if (preg_match('/^8[0-9]{10}$/', $phone)) {
            return '+7' . substr($phone, 1);
        }

        if (preg_match('/^[0-9]{10}$/', $phone)) {
            return "+7{$phone}";
        }

        return null;
    }

    private function tryNormalizeKazakhstanPhoneNumber(string $phone): ?string
    {
        if (preg_match('/^7[0-9]{9,11}$/', $phone)) {
            return "+{$phone}";
        }

        if (preg_match('/^\+7[0-9]{9,11}$/', $phone)) {
            return $phone;
        }

        if (preg_match('/^8[0-9]{9,11}$/', $phone)) {
            return '+7' . substr($phone, 1);
        }

        if (preg_match('/^[0-9]{9,11}$/', $phone)) {
            return "+7{$phone}";
        }

        return null;
    }

    private function tryNormalizeUzbekistanPhoneNumber(string $phone): ?string
    {
        if (preg_match('/^998[0-9]{9}$/', $phone)) {
            return "+{$phone}";
        }

        if (preg_match('/^\+998[0-9]{9}$/', $phone)) {
            return $phone;
        }

        if (preg_match('/^[0-9]{9}$/', $phone)) {
            return "+998{$phone}";
        }

        return null;
    }
}

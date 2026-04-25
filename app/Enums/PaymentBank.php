<?php

namespace App\Enums;

enum PaymentBank: string
{
    case QRIS = 'qris';
    case GOPAY = 'gopay';
    case BCA = 'bca';
    case MANDIRI = 'mandiri';
    case BNI = 'bni';
    case BRI = 'bri';
    case BSI = 'bsi';

    public function label(): string
    {
        return match($this) {
            self::QRIS => 'QRIS',
            self::GOPAY => 'GoPay',
            self::BCA => 'BCA',
            self::MANDIRI => 'Mandiri',
            self::BNI => 'BNI',
            self::BRI => 'BRI',
            self::BSI => 'BSI',
        };
    }

    public static function getLabel(?string $value): string
    {
        if (!$value) return '';
        $case = self::tryFrom(strtolower($value));
        return $case ? $case->label() : strtoupper($value);
    }

    public static function allLabels(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label()
        ])->toArray();
    }
}

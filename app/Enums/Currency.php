<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Currency: string implements HasLabel
{
    case Inr = 'inr';
    case Usd= 'usd';
    case Eur = 'eur';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Inr => 'INR',
            self::Usd => 'USD',
            self::Eur => 'EUR',
        };
    }
}

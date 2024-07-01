<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentMethod: string implements HasLabel
{
    case Stripe = 'stripe';
    case Cod= 'cod';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Stripe => __('site.stripe'),
            self::Cod => __('site.cod'),
        };
    }
}

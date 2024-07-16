<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ShippingMethod: string implements HasLabel
{
    case Fedex = 'fedex';
    case Ups = 'ups';
    case Usps = 'usps';
    case Hdl = 'hdl';
    case None = 'none';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Fedex => 'FedEx',
            self::Ups => 'UPS',
            self::Usps => 'USPS',
            self::Hdl => 'HDL',
            self::None => 'NONE',
        };
    }
}

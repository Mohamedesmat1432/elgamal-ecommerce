<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentStatus: string implements HasLabel
{
    case Pending = 'pending';
    case Paid= 'paid';
    case Faild = 'faild';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pending => __('site.pending'),
            self::Paid => __('site.paid'),
            self::Faild => __('site.faild'),
        };
    }
}

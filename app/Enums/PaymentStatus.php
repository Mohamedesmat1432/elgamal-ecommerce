<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentStatus: string implements HasLabel
{
    case Pending = 'pending';
    case Paid= 'paid';
    case Failed = 'failed';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pending => __('site.pending'),
            self::Paid => __('site.paid'),
            self::Failed => __('site.failed'),
        };
    }
}

<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum OrderStatus: string implements HasLabel, HasIcon, HasColor
{
    case New = 'new';
    case Processing= 'processing';
    case Shipped = 'shipped';
    case Delivered = 'delivered';
    case Canceled = 'canceled';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::New => __('site.new'),
            self::Processing => __('site.processing'),
            self::Shipped => __('site.shipped'),
            self::Delivered => __('site.delivered'),
            self::Canceled => __('site.canceled'),
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::New => 'info',
            self::Processing => 'primary',
            self::Shipped => 'success',
            self::Delivered => 'success',
            self::Canceled => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::New => 'heroicon-m-sparkles',
            self::Processing => 'heroicon-m-arrow-path',
            self::Shipped => 'heroicon-m-truck',
            self::Delivered => 'heroicon-m-check-circle',
            self::Canceled => 'heroicon-m-x-circle',
        };
    }
}

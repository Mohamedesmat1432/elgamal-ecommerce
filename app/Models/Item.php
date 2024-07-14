<?php

namespace App\Models;

use App\Observers\ItemObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'items';

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'images',
        'description',
        'price',
        'is_featured',
        'is_active',
        'in_stock',
        'on_sale'
    ];

    protected $casts = [
        'images' => 'array'
    ];

    protected static function boot() {
        parent::boot();
        static::observe(ItemObserver::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeIsActive($query, $boolean)
    {
        return $query->where('is_active', $boolean);
    }

    public function scopeInStock($query, $boolean)
    {
        return $query->where('in_stock', $boolean);
    }

    public function scopeOnSale($query, $boolean)
    {
        return $query->where('on_sale', $boolean);
    }
}

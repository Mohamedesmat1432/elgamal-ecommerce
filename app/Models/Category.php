<?php

namespace App\Models;

use App\Observers\CategoryObsrver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'image',
        'is_active',
    ];

    protected static function boot() {
        parent::boot();
        static::observe(CategoryObsrver::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function scopeIsActive($query, $boolean)
    {
        return $query->where('is_active', $boolean);
    }
}

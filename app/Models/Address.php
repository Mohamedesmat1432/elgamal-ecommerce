<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'addresses';

    protected $fillable = [
        'f_name',
        'l_name',
        'phone',
        'email',
        'street',
        'city',
        'country',
        'zip_code'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->f_name} {$this->l_name}";
    }
}

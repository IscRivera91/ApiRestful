<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    const PRODUCT_AVAILABLE = 'available';
    const PRODUCT_NO_AVAILABLE = 'no available';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
        'image',
        'seller_id',

    ];

    public function isAvailable(): bool
    {
        return $this->status == self::PRODUCT_AVAILABLE;
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function seller(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Seller::class);
    }

    public function transactions(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Transaction::class);
    }

}

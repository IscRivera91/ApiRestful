<?php

namespace App\Models;

use App\Scopes\SellerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seller extends User
{
    use HasFactory;

    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope(new SellerScope);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class);
    }
}

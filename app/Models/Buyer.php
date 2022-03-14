<?php

namespace App\Models;

use App\Scopes\BuyerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buyer extends User
{
    use HasFactory;

    protected static function booted()
    {
        parent::booted();
        static::addGlobalScope(new BuyerScope);
    }

    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Seller
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $verified
 * @property string|null $verification_token
 * @property string $admin
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|Seller newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Seller newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Seller query()
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereVerificationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Seller whereVerified($value)
 * @mixin \Eloquent
 */
class Seller extends User
{
    use HasFactory;

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'promotion_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function getSubtotalAttribute(): float
    {
        return $this->items->sum(fn($item) => $item->unit_price * $item->quantity);
    }

    public function getDiscountAmountAttribute(): float
    {
        if (! $this->promotion) return 0;

        return $this->promotion->computeDiscount($this->subtotal);
    }

    public function getTotalAttribute(): float
    {
        return max(0, $this->subtotal - $this->discount_amount);
    }
}

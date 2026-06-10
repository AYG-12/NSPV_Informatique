<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'description', 'type', 'value',
        'min_order_amount', 'usage_limit', 'usage_count',
        'starts_at', 'expires_at', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'value'            => 'float',
            'min_order_amount' => 'float',
            'starts_at'        => 'datetime',
            'expires_at'       => 'datetime',
            'is_active'        => 'boolean',
        ];
    }

    public function isValid(float $orderAmount = 0): bool
    {
        if (! $this->is_active) return false;
        if ($this->starts_at && now()->lt($this->starts_at)) return false;
        if ($this->expires_at && now()->gt($this->expires_at)) return false;
        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) return false;
        if ($this->min_order_amount && $orderAmount < $this->min_order_amount) return false;

        return true;
    }

    public function computeDiscount(float $subtotal): float
    {
        if ($this->type === 'percent') {
            return round($subtotal * $this->value / 100, 2);
        }

        return min($this->value, $subtotal);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}

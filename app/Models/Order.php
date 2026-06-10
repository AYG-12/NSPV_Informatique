<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'address_id', 'promotion_id', 'order_number',
        'status', 'delivery_type', 'subtotal', 'discount_amount', 'total', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'subtotal'        => 'float',
            'discount_amount' => 'float',
            'total'           => 'float',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $datePart = now()->format('Ym');
                $prefix   = 'CMD-' . $datePart;

                $last = static::where('order_number', 'like', $prefix . '%')
                    ->orderByDesc('id')
                    ->value('order_number');

                $seq = 1;
                if ($last) {
                    $seqStr = substr($last, strlen($prefix), 4);
                    $seq    = ((int) $seqStr) + 1;
                }

                $sequential = str_pad($seq, 4, '0', STR_PAD_LEFT);
                $hex        = strtoupper(bin2hex(random_bytes(3)));

                $order->order_number = $prefix . $sequential . '-' . $hex;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending'    => 'En attente',
            'confirmed'  => 'Confirmée',
            'processing' => 'En traitement',
            'shipped'    => 'Expédiée',
            'delivered'  => 'Livrée',
            'cancelled'  => 'Annulée',
            default      => $this->status,
        };
    }

    public function getDeliveryTypeLabelAttribute(): string
    {
        return match ($this->delivery_type) {
            'pickup'  => 'Retrait en boutique',
            default   => 'Livraison à domicile',
        };
    }
}

<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Notifications\Notification;

class LowStockNotification extends Notification
{
    public function __construct(private Product $product) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'icon'    => 'stock',
            'title'   => 'Stock faible',
            'message' => '"' . $this->product->name . '" — '
                       . $this->product->stock . ' unité' . ($this->product->stock > 1 ? 's' : '') . ' restante' . ($this->product->stock > 1 ? 's' : ''),
            'url'     => route('admin.produits'),
        ];
    }
}

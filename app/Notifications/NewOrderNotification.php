<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    public function __construct(private Order $order) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'icon'    => 'order',
            'title'   => 'Nouvelle commande',
            'message' => $this->order->order_number . ' — ' . $this->order->user->name
                       . ' — ' . number_format($this->order->total, 0, ',', ' ') . ' F CFA',
            'url'     => route('admin.commandes'),
        ];
    }
}

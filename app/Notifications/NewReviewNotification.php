<?php

namespace App\Notifications;

use App\Models\Review;
use Illuminate\Notifications\Notification;

class NewReviewNotification extends Notification
{
    public function __construct(private Review $review) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'icon'    => 'review',
            'title'   => 'Nouvel avis client',
            'message' => ($this->review->user->name ?? 'Client')
                       . ' — ' . $this->review->rating . '/5'
                       . ' sur "' . ($this->review->product->name ?? 'produit') . '"',
            'url'     => route('admin.avis'),
        ];
    }
}

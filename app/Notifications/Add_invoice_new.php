<?php

namespace App\Notifications;

use App\Models\invoices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class Add_invoice_new extends Notification
{
    use Queueable;
    private $invoices;
    /**
     * Create a new notification instance.
     */
    public function __construct(invoices $invoices)
    {
        $this->invoices = $invoices;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [

            //'data' => $this->details['body']
            'id' => $this->invoices->id,
            'title' => 'تم اضافة فاتورة جديد بواسطة :',
            'user' => Auth::user()->name,

        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

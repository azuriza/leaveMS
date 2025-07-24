<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CutiDisetujuiNotification extends Notification
{
    use Queueable;

    protected $cuti;

    public function __construct($cuti)
    {
        $this->cuti = $cuti;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Cuti Anda dari ' . $this->cuti->leave_from . ' sampai ' . $this->cuti->leave_to . ' telah disetujui.',
            'url' => url('show/applyleave') // perhatikan: tidak ada typo!
        ];
    }
}

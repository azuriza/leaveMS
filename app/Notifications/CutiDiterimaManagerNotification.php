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
            'message' => 'Pengajuan Cuti ' . $this->cuti->leavetype->leave_type . ' oleh ' . $this->cuti->User->name . $this->cuti->User->last_name .' .',
            'url' => url('manager/applyleave') // perhatikan: tidak ada typo!
        ];
    }
}

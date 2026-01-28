<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicationStatusNotification extends Notification
{
    use Queueable;

    protected $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'application_status',
            'job_id' => $this->application->job->id,
            'job_title' => $this->application->job->title,
            'status' => $this->application->status,
            'message' => match ($this->application->status) {
                'aprovado' => 'Sua candidatura foi aprovada 🎉',
                'recusado' => 'Sua candidatura foi recusada',
                default => 'Status atualizado',
            },
        ];
    }
}

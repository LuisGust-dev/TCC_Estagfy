<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewApplicationNotification extends Notification
{
    use Queueable;

    protected $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    // Onde será armazenada
    public function via($notifiable)
    {
        return ['database'];
    }

    // Dados que vão para o banco
    public function toDatabase($notifiable)
    {
        return [
            'type' => 'new_application',
            'job_id' => $this->application->job->id,
            'job_title' => $this->application->job->title,
            'student_name' => $this->application->student->name,
            'message' => 'Novo candidato para sua vaga',
        ];
    }
}

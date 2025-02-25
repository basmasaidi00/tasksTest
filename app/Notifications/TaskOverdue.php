<?php
namespace App\Notifications;

use App\Models\tasks;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Notification\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification as BaseNotification;

class TaskOverdue extends BaseNotification
{
    use Queueable;

    protected $task;

    public function __construct(tasks $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail']; // Définir le canal comme étant l'email
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Tâche en retard')
                    ->line('La tâche "' . $this->task->title . '" est en retard.')
                    ->line('La date limite était le ' . $this->task->due_date->format('d-m-Y') . '.')
                    ->action('Voir la tâche', url('/tasks/' . $this->task->id));
    }

    public function toArray($notifiable)
    {
        return [
            'task_id' => $this->task->id,
            'title' => $this->task->title,
            'due_date' => $this->task->due_date,
        ];
    }
}

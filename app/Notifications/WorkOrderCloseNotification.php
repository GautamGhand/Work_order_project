<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\WorkOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkOrderCloseNotification extends Notification
{
    use Queueable;

    public $user;
    public $workorder;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user,WorkOrder $workorder)
    {
        $this->user=$user;
        $this->workorder=$workorder;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Work Order has Been Closed')
                    ->line('Welcome '.$notifiable->full_name)
                    ->line('Title '.$this->workorder->title)
                    ->line('Description '.$this->workorder->note)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'to' => $notifiable,
            'from' => $this->user
        ];
    }
}

<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;

class PostNotification extends Notification
{
    public $title;

    public function __construct($title)
    {
        $this->title = $title;
    }

    public function via($notifiable)
    {
        return ['mail','nexmo'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line("This is your title" . $this->title)
                    ->line("Thank u for posting our site")
                    ->line("Wait for ur Approval")
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');

    }

	public function toNexmo($notifiable)
	{
		return (new NexmoMessage())->content('Your SMS message content');
	}

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

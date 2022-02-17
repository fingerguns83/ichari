<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClaimStatusChanged extends Notification
{
    use Queueable;

    protected $claim;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($claim)
    {
        $this->claim = $claim;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
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
        if ($this->claim->status > 1){
            $title = 'Claim Status Changed';
        }
        else {
            $title = 'New Claim Created';
        }
        $output = [
            'title' => $title,
            'claim_type' => $this->claim->type,
            'claim_location' => $this->claim->getLocationString(),
            'claim_status' => $this->claim->getStatusString()
        ];
        if ($this->claim->expires_on){
            $output['expires_on'] = $this->claim->expires_on;
        }
        return $output;
    }
}

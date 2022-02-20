<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class ClaimStatusChanged extends Notification
{
    use Queueable;

    protected $claim;
    protected $recipient;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($claim, $recipient)
    {
        $this->recipient = $recipient;
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
        if ($this->claim->requested_by !== $this->recipient->id){
            $requestedByUser = DB::table('users')
                ->select('username')
                ->where('id', '=', $this->claim->requested_by)
                ->first();
            $requestedBy = $requestedByUser->username;
        }

        $claimType = DB::table('claim_types')
            ->select('name')
            ->where('id', '=', $this->claim->type)
            ->first();


        $message = "The " . $claimType->name . " located at " . $this->claim->getLocationString() . " ";

        if (isset($requestedBy)){
            $message .= "that was requested by " . $requestedBy . " ";
        }

        $message .= "has had its status changed to " . strtoupper($this->claim->getStatusString()) . ".";
        if ($this->claim->expires_on){
            $userTimezone = new \DateTimeZone($this->recipient->timezone);
            $expireServer = new \DateTime($this->claim->expires_on);
            $expireServer->setTimezone($userTimezone);
            $expires_on = $expireServer->format('F dS');
            $message .= " This claim will expire on " . $expires_on . ".";
        }

        $output = [
            'title' => $title,
            'message' => $message
        ];

        return $output;
    }
}

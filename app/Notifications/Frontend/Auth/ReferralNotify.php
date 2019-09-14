<?php

namespace App\Notifications\Frontend\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Class UserNeedsConfirmation.
 */
class ReferralNotify extends Notification
{
    use Queueable;

    /**
     * @var
     */
    protected $newUser;

    /**
     * ReferralNotify constructor.
     *
     * @param $newUser
     */
    public function __construct($newUser)
    {
        $this->newUser = $newUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject(app_name().': '.__('New Referral'))
            ->line(__('New user has just registered using your referral link.'))
            ->line(__('ID: ') . $this->newUser->id)
            ->line(__('strings.emails.auth.thank_you_for_using_app'));
    }
}

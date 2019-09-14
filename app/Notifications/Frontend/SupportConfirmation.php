<?php

namespace App\Notifications\frontend;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Http\Requests\Frontend\Contact\SendContactRequest;

class SupportConfirmation extends Notification
{
    use Queueable;

    private $request;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(SendContactRequest $request)
    {
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    private function getRequestTable()
    {
        return '
<style>td {vertical-align: top;}</style>
<blockquote style="padding:10px;border: 1px solid #dddfe2;;background:#e7e8ea;color:#464a4e;font-size:80%;">
<table>
    <tr>
        <td>Transaction ID:</td>
        <td>'. strip_tags($this->request->transaction_id) .'</td>
    </tr>   
    <tr>
        <td style="white-space: nowrap;">Transaction Hash:</td>
        <td>'. strip_tags($this->request->transaction_hash) .'</td>
    </tr>   
    <tr>
        <td>Message:</td>
        <td>'. strip_tags($this->request->message) .'</td>
    </tr>            
</table>
</blockquote>
        ';
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
            ->subject(app_name() . ': ' . __('Support Confirmation'))
            ->line('Your request has been received and is being reviewed by our support staff.')
            ->line($this->getRequestTable())
            ->line(__('strings.emails.auth.thank_you_for_using_app'));
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
            //
        ];
    }
}

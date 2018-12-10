<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InviteToAppNotification extends Notification
{
    use Queueable;
    protected $signUpLink;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($link)
    {
        $this->signUpLink = $link;
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

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Bạn có 1 lời mời tham gia vào ứng dụng AS TeamCollaborate.')
                    ->line('Để chấp nhận lời mời và tham gia ứng dụng hãy nhấn nút dưới đây.')
                    ->action('Chấp nhận', $this->signUpLink)
                    ->line('Bạn có thể bỏ qua tin nhắn này nếu cảm thấy bị làm phiền, chúng tôi rất xin lỗi vì điều này!')
                    ->line('Nếu bạn không nhấn được nút trên hãy sử dụng đường dẫn dưới đây.')
                    ->line($this->signUpLink);
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

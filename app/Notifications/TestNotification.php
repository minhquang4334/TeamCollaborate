<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class TestNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $token;
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast', WebPushChannel::class];
    }


    public function toArray($notifiable)
    {
        return [
            'title' => 'Maria Ozawa!',
            'body' => '痛い、行く、行く',
            'action_url' => '/',
            'created' => Carbon::now()->toIso8601String(),
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage())
            ->title('ハポソフト!')
            ->icon('/images/logo_header.png')
            ->body('どうも、有り難うございます')
            ->action('View app', 'view_app')
            ->data(['id' => $notification->id,
            ]);
    }
}

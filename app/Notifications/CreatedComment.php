<?php

namespace App\Notifications;

use App\Model\Channel;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class CreatedComment extends Notification
{
	use Queueable;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public $token;
	public $comment;
	public $author;
	public function __construct($token, $comment, $author)
	{
		$this->token = $token;
		$this->comment = $comment;
		$this->author = $author;
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
		$subcontent = $this->comment->content;
		if(strlen($this->comment->content) > 30) {
			$subcontent = substr($this->comment->content, 0, 30);
			$subcontent = $subcontent.'.....';
		}
		$channel = new Channel();
		$channel = $channel->findOrFail($this->comment->channel_id);
		$subcontent = 'to '.$channel->name.' : '.$subcontent;
		$action_link = 'http://localhost:8000/#/';
		if($channel->channel_id == Channel::GENERAL_CHANNEL_ID) {
			$action_link = $action_link.'general';
		} else {
			$action_link = $action_link.'channel/'.$channel->channel_id;
		}
		return (new WebPushMessage())
			->title($this->author->name.' đã đăng một bài viết mới ')
			->icon('/images/logo.jpg')
			->body($subcontent)
			->action('View Post', $action_link)
			->data(['id' => $notification->id,
			]);
	}
}

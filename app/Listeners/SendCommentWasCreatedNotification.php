<?php

namespace App\Listeners;

use App\Events\CommentWasCreated;
use App\Model\Post;
use App\Model\User;
use App\Notifications\CreatedComment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCommentWasCreatedNotification
{
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  NotificationToUser  $event
	 * @return void
	 */
	public function handle(CommentWasCreated $event)
	{
		$followUsers = $event->followUsers;
		$comment = $event->comment;
		$author = $event->author;
		foreach ($followUsers as $subUser) {
			$user = User::findOrFail($subUser->id);
			if($subUser->id != $author->id) {
				$user->notify(new CreatedComment($user->token, $comment, $author));
			}
		}
	}

}

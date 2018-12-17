<?php

namespace App\Http\Controllers\Api;

use App\Events\NotificationRead;
use App\Events\NotificationReadAll;
use App\Events\NotificationToUser;
use App\Model\Notification;
use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use NotificationChannels\WebPush\PushSubscription;

class NotificationApiController extends ApiController
{
    /**
     * Get user's notifications.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        // Limit the number of returned notifications, or return all
        $query = $user->notifications();
        $limit = (int) $request->input('limit', 0);
        if ($limit) {
            $query = $query->limit($limit);
        }

        $notifications = $query->get()->each(function ($notification) {
            $notification->created = $notification->created_at->toIso8601String();
        });
        $total = $user->unreadNotifications->count();
        return compact('notifications', 'total');
    }

    /**
     * Create a new notification.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subUsers = DB::table('push_subscriptions')->get();
	    event(new NotificationToUser($subUsers));
        return response()->json('Notification sent.', 201);
    }

    /**
     * Mark user's notification as read.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = $request->user()
            ->notifications()
            ->find($id);
        if (is_null($notification)) {
            return response()->json('Notification not found.', 404);
        }
        $notification->is_read = true;
        $notification->markAsRead();
        $notification->save();
        event(new NotificationRead($request->user()->id, $id));
    }

    /**
     * Mark all user's notifications as read.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function markAllRead(Request $request)
    {
        $request->user()
            ->unreadNotifications()
            ->get()->each(function ($n) {
                $n->is_read = true;
                $n->markAsRead();
            });

        event(new NotificationReadAll($request->user()->id));
    }

    /**
     * Mark the notification as read and dismiss it from other devices.
     *
     * This method will be accessed by the service worker
     * so the user is not authenticated and it requires an endpoint.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function dismiss(Request $request, $id)
    {
        if (empty($request->endpoint)) {
            return response()->json('Endpoint missing.', 403);
        }

        $subscription = PushSubscription::findByEndpoint($request->endpoint);
        if (is_null($subscription)) {
            return response()->json('Subscription not found.', 404);
        }

        $notification = $subscription->user->notifications()->where('id', $id)->first();
        if (is_null($notification)) {
            return response()->json('Notification not found.', 404);
        }
        $notification->is_read = true;
        $notification->markAsRead();

        event(new NotificationRead($subscription->user->id, $id));
    }
}

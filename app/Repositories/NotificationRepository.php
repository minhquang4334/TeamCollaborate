<?php

namespace App\Repositories;

use App\Model\Notification;
use Illuminate\Support\Facades\Auth;
use Mockery\Matcher\Not;

class NotificationRepository {
    use BaseRepository;
    //

    protected $model;

    /**
     * Constructor
     *
     * @param Notification $notification
     */

    public function __construct(Notification $notification)
    {
        $this->model = $notification;
    }

}

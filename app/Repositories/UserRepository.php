<?php

namespace App\Repositories;

use App\Model\Channel;
use App\Model\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mockery\Matcher\Not;

class UserRepository {
    use BaseRepository;
    //

    protected $model;

    /**
     * Constructor
     *
     * @param User $user
     */

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function updateStatus($status, $id){
        $user = $this->getById($id);
        $user->active = $status;
        $this->update($id,$user->toArray());
        return $status;
    }

    public function takePartInChannels($id){
        $channels = $this->getById($id)->channels->unique()->toArray();
        $channels = array_filter($channels, function ($channel) {
            return $channel['status'] == Channel::ACTIVE;
        });
        return $channels;
    }

    public function isRegistered($email){
        return ($this->model->where('email', $email)->count() > 0);
    }

}

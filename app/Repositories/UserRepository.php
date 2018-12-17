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

    const YEARLY = 'yearly';
    const MONTHLY = 'monthly';
    const DAILY = 'daily';
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

    /**
     * @param $type
     * @return records for chart
     *
     */
    public function getChart($type){
        switch ($type){
            case self::YEARLY:
                return $this->model
                    ->select(DB::raw('CONCAT(YEAR(created_at), " year" ) AS period , COUNT(*) AS model'))
                    ->groupBy('period')
                    ->get();
            case self::MONTHLY:
                return $this->model
                    ->select(DB::raw('CONCAT(YEAR(NOW()), "-", MONTH(created_at)) AS period, COUNT(*) AS model'))
                    ->whereRaw('YEAR(created_at) = YEAR(NOW())')
                    ->groupBy('period')
                    ->get();
            case self::DAILY:
                return $this->model
                    ->select(DB::raw('CONCAT(YEAR(NOW()), "-", MONTH(NOW()), "-", DAY(created_at)) AS period, COUNT(*) AS model'))
                    ->whereRaw('YEAR(created_at) = YEAR(NOW()) AND MONTH(created_at) = MONTH(NOW())')
                    ->groupBy('period')
                    ->get();
        }
        return null;
    }
}

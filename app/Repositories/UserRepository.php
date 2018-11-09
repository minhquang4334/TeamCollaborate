<?php

namespace App\Repositories;

use App\Model\User;
use Illuminate\Support\Facades\Auth;
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
}

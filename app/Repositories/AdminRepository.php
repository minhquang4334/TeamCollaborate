<?php

namespace App\Repositories;

use App\Model\Admin;
use App\Model\User;
use Illuminate\Support\Facades\Auth;

class AdminRepository {
    use BaseRepository;
    //

    /**
     * User Model
     *
     * @var User
     */
    protected $model;

    /**
     * Constructor
     *
     * @param Admin $admin
     */
    public function __construct(Admin $admin)
    {
        $this->model = $admin;
    }

}

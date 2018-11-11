<?php

namespace App\Repositories;

use App\Model\Invite;
use Illuminate\Support\Facades\Auth;

class InviteRepository {
    use BaseRepository;
    //

    protected $model;

    /**
     * Constructor
     *
     * @param Invite $invite
     */

    public function __construct(Invite $invite)
    {
        $this->model = $invite;
    }

}

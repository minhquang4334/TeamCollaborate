<?php

namespace App\Http\Controllers\Api;

use App\Repositories\InviteRepository;

class InviteApiController extends ApiController
{
    protected $invite;

    /**
     * UserApiController constructor.
     * @param InviteRepository $invite
     */
    public function __construct(InviteRepository $invite)
    {
        parent::__construct();
        $this->invite = $invite;
    }




}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\EditInfoRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Request;

class UserApiController extends ApiController
{
    protected $user;

    /**
     * UserApiController constructor.
     * @param UserRepository $user
     */
    public function __construct(UserRepository $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * edit user information.
     * EditInfoRequest validate request before handle
     * $request has user_id, user_information
     * @param EditInfoRequest $request
     * return user updated information
     * @return response()
     */
    public function editInfo(EditInfoRequest $request) {
        return response();
    }

    /**
     * change password
     * ChangePasswordRequest validate request before handle
     * @param ChangePasswordRequest $request
     * return true if success, if not return false
     */
    public function changePassword(ChangePasswordRequest $request) {

    }


    /**
     * get list user with keyword username in request
     * if $request->has('search_name') return list username like *search_name*
     * else return list username
     * @param Request $request
     */
    public function getListUser(Request $request) {

    }

    /**
     * delete Current User Account
     * check current user id same $request->user_id
     * @param Request $request
     */
    public function deleteAccount(Request $request) {

    }

    /**
     * get list user of channel
     * request has channel_id
     * return list user of channel
     * @param Request $request
     */
    public function getListUserInChannel(Request $request) {

    }

    /**
     * change Display name of user in specific channel
     * $request has channel_id
     * @param Request $request
     */
    public function changeDisplayName(Request $request) {

    }





}

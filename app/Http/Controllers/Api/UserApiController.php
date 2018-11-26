<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\ChangeDisplayNameRequest;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\EditInfoRequest;
use App\Repositories\ChannelRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserApiController extends ApiController
{
    protected $user;
    protected $channel;
    /**
     * UserApiController constructor.
     * @param UserRepository $user
     * @param ChannelRepository $channel
     */
    public function __construct(UserRepository $user, ChannelRepository $channel)
    {
        parent::__construct();
        $this->user = $user;
        $this->channel = $channel;
    }

    /**
     *  METHOD PUT
     * usage http://localhost:8000/api/user/update?is_teacher=1&facebook_url=http://f.....
     * $allow =  ['university','status','phone_number','name',
                'japanese_level','japanese_certificate',
                'is_teacher','is_bachelor','grade','gender',
                'facebook_url','email_verified_at','email','birthday',
                'avatar','address','about_me',];
     *
     * edit user information.
     * EditInfoRequest validate request before handle
     * $request has user's information
     * @param EditInfoRequest $request
     * return user updated information
     * @return JsonResponse
     */
    public function editInfo(EditInfoRequest $request) {
       $allow =  ['university','status','phone_number','name',
                    'japanese_level','japanese_certificate',
                    'is_teacher','is_bachelor','grade','gender',
                    'facebook_url','email_verified_at','email','birthday',
                    'avatar','address','about_me',];
       try{
            $id = $this->currentUser()->id;
            $updateInput = array_filter(array_intersect_key($request->all(), array_flip($allow) ));
            $success = $this->user->updateColumn($id, $updateInput);
            if($success){
                $user = $this->user->getById($id);
                return response()->json(['status' => true, 'data' => $user], self::CODE_UPDATE_SUCCESS);
            }else{
                return response()->json(['status' => true, 'data' => 'Update failed'], self::CODE_INTERNAL_ERROR);
            }
       }catch(\Exception $e){
           return response()->json(['status' => false, 'data' => $e->getMessage()], self::CODE_FORBIDDEN);
       }
    }

    /**
     *
     * http://localhost:8000/api/user/change-password?old_password=123456&new_password=123456&new_password_confirmation=123456
     * method put
     * required
     * old_password
     * new_password
     * new_password_confirmation
     * change password
     * ChangePasswordRequest validate request before handle
     * @param ChangePasswordRequest $request
     * return true if success, if not return false
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request) {
        try{
            $id = $this->currentUser()->id;
            $user = $this->user->getById($id);
            $success = false;
            if(Hash::check($request->get('old_password'), $user->password)){
                $success = $this->user->updateColumn($id, ['password' => bcrypt($request->get('new_password'))]);
            }
            return response()->json(['status' => $success, 'data' => $success], self::CODE_UPDATE_SUCCESS);
        }catch(\Exception $e){
            return response()->json(['status' => false, 'data' => $e->getMessage()], self::CODE_INTERNAL_ERROR);
        }
    }


    /**
     * method get
     * usage: http://localhost:8000/api/user/list?{{search_name=user}:nullable}
     * get list user with keyword username in request
     * if $request->has('search_name') return list username like *search_name*
     * else return list username
     * @param Request $request
     * @return JsonResponse
     */
    public function getListUser(Request $request) {
        try {
            $name = $request->get('search_name');
            $users = $this->user->getByLike('name', $name)->get();
            return response()->json(['status' => true, 'data' => $users], self::CODE_GET_SUCCESS);
        }catch (\Exception $e){
            return response()->json(['status' => false, 'data' => $e->getMessage()], self::CODE_BAD_REQUEST);
        }
    }

    /**
     * usage http://localhost:8000/api/user/delete
     * delete Current User Account
     * use $this->currentUser() to get current user
     * @return JsonResponse
     */
    public function deleteAccount() {
        try{
            $id = $this->currentUser()->id;
            $success = $this->user->destroy($id);
            return response()->json(['status' => true, 'data' => $success,], self::CODE_DELETE_SUCCESS);
        }catch (\Exception $e){
            return response()->json(['status' => false, 'data' => $e->getMessage()], self::CODE_INTERNAL_ERROR);
        }
    }

    /**
     * method get
     * usage: http://localhost:8000/api/user/users?channel_id={{id}}
     * get list user of channel
     * request has channel_id
     * return list user of channel
     * @param Request $request
     * @return JsonResponse
     */
    public function getListUserInChannel(Request $request) {
        try{
            $id = $request->get('channel_id');
            $users = $this->channel->getById($id)->users;
            return response()->json(['status' => true, 'data' => $users], self::CODE_GET_SUCCESS);
        }catch (\Exception $e){
            return response()->json(['status' => false, 'data' => $e->getMessage()], self::CODE_INTERNAL_ERROR);
        }
    }

    /**
     * Method put
     * usage: http://localhost:8000/api/user/change-name?channel_id=2&display_name=Hehehe
     * change Display name of user in specific channel
     * $request has channel_id
     * @param ChangeDisplayNameRequest $request
     * @return JsonResponse
     */
    public function changeDisplayName(ChangeDisplayNameRequest $request) {
        try{
            $channelId = $request->get('channel_id');
            $name   = $request->get('display_name');
            $channel = $this->channel->getById($channelId);
            $user = $this->currentUser();
            if($user->channels->contains($channel)) {
                $user->channels()->sync([$channelId => ['display_name' => $name]]);
                return response()->json(['status' => true, 'data' => $user], self::CODE_UPDATE_SUCCESS);
            }else{
                return response()->json(['status' => false, 'data' => trans('messages.user.not_in_channel')], self::CODE_UNAUTHORIZED);
            }
        }catch (\Exception $e){
            return response()->json(['status' => false, 'data' => $e->getMessage()], self::CODE_INTERNAL_ERROR);
        }
    }




}

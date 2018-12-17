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
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;


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
     *           'japanese_level','japanese_certificate',
     *           'is_teacher','is_bachelor','grade','gender',
     *           'facebook_url','email_verified_at','email','birthday',
     *           'avatar','address','about_me',];
     *
     * edit user information.
     * EditInfoRequest validate request before handle
     * $request has user's information
     * @param EditInfoRequest $request
     * return user updated information
     * @return JsonResponse
     */
    public function changeUserProfile(EditInfoRequest $request) {
       $allow =  ['university','status','phone_number','name',
                    'japanese_level','japanese_certificate',
                    'is_teacher','is_bachelor','grade','gender',
                    'facebook_url','email_verified_at','email','birthday',
                    'address','about_me',];
       try{
            $id = $this->currentUser()->id;
            $updateInput = array_filter(array_intersect_key($request->all(), array_flip($allow) ));
            $success = $this->user->updateColumn($id, $updateInput);
            if($success){
                $user = $this->user->getById($id);
                return $this->response->withUpdated($user);
            }else{
                return $this->response->withForbidden(trans('user.messages.update_info_fail'));
            }
       }catch(\Exception $e){
           return $this->response->withInternalServer($e->getMessage());
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
            if ($success)
                return $this->response->withMessage(trans('messages.user.password_reset_success'));
            else
                return $this->response->withForbidden(trans('messages.user.password_reset_fail'));
        }catch(\Exception $e){
            return $this->response->withForbidden(trans('messages.user.password_reset_fail'));
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
            return $this->response->withArray($users);
        }catch (\Exception $e){
            return $this->response->withNotFound($e->getMessage());
        }
    }

    /**
     * usage http://localhost:8000/api/user/delete
     * delete Current User Account
     * use $this->currentUser() to get current user
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteAccount(Request $request) {
	    if(Hash::check($request->get('password'), $this->currentUser()->password)) {
		    try {
			    $id = $this->currentUser()->id;
			    $this->user->destroy($id);
			    return $this->response->withMessage(trans('messages.user.delete_account_success'));
		    } catch (\Exception $e) {
			    return $this->response->withInternalServer(trans('messages.user.delete_account_fail'));
		    }
	    } else {
	    	return response()->json(['status' => false], 200);
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
            return $this->response->withArray($users);
        }catch (\Exception $e){
            return $this->response->withNotFound($e->getMessage());
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
                return $this->response->withUpdated($user);
            }else{
                $this->response->withForbidden(trans('messages.user.not_in_channel'));
            }
        }catch (\Exception $e){
            $this->response->withInternalServer($e->getMessage());
        }
    }

    /**
     * Method post
     * usage: http://localhost:8000/api/user/avatar
     * change Display avatar of user in specific channel
     * $request has channel_id
     * @param Request $request
     * @return JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function changeUserAvatar(Request $request) {
	    $this->validate($request, ['photo' => ['required', 'image', Rule::dimensions()->minWidth(250)->minHeight(250)],]);
	    try {
		    // validate

		    // fill variables
		    $filename = time() . str_random(16) . '.png';
		    $image = Image::make($request->file('photo')->getRealPath());
		    $folder = config('const.avatar_folder');

		    // crop it
		    $image = $image->resize(250, 250);

		    // optimize it
		    $image->encode('png', 60);

		    // upload it
		    Storage::put('public/'.$folder . '/' . $filename, $image);
		    $imageAddress = $folder . '/' . $filename;

		    // delete the old avatar
		    if (isset($this->currentUser()->avatar)) {
			    Storage::delete($folder . str_after($this->currentUser()->avatar, 'public/'.$folder));
		    }

		    // update user's avatar
		    $this->user->updateColumn($this->currentUser()->id, ['avatar' => ('storage/'.$imageAddress),]);
		    return response()->json(['image_address' => Storage::url($imageAddress)], 200);

	    }
	    catch (\Exception $e) {
		    return $this->response->withInternalServer($e->getMessage());
	    }

    }


}

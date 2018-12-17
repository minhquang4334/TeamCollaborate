<?php

namespace App\Http\Controllers\Api;

use App\Events\ChannelWasDeleted;
use App\Events\InvitedToChannel;
use App\Http\Requests\User\CreateChannelRequest;
use App\Http\Requests\User\UpdateChannelRequest;
use App\Model\Channel;
use App\Repositories\ChannelRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class ChannelApiController extends ApiController
{
    protected $channel;
    protected $user;

    /**
     * ChannelApiController constructor.
     * @param ChannelRepository $channel
     * @param UserRepository $user
     */
    public function __construct(ChannelRepository $channel, UserRepository $user)
    {
        parent::__construct();
        $this->channel = $channel;
        $this->user = $user;
    }

    /**
     * Method POST
     * usage: http://localhost:8000/api/channel/create?type=1&purpose=For study&description=This is my Foa&channel_id=hahha&invited_users[]=1&invited_users[]=2
     * add new channel
     * return new channel information if success, else return error message
     * @param CreateChannelRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateChannelRequest $request) {
        try{
        	$type = $request->get('type') ? $request->get('type') : 0;
        	if($type === Channel::PROTECTED) {
        		$invited_users = $request->get('invited_users');
        		array_push($invited_users, $this->currentUser()->id);
        		$findChannelId = $this->channel->findSameChannelWithDirectMessage($invited_users);
        		if($findChannelId) {
        			return $this->response->withCreated($this->channel->getById($findChannelId));
		        }
	        }
	        $str_random = strtoupper(str_random(config('const.length_channel_code')));
            $channel = $this->channel->store(array_merge($request->all(), [
                'creator' => $this->currentUser()->id,
                'status'  => Channel::ACTIVE,
            ]));
            $channel_code = $str_random.$channel->id;
			      $this->channel->updateColumn($channel->id, ['channel_id' => $channel_code]);
            if($request->has('invited_users')){
                $members = array_unique(array_merge($request->get('invited_users'), [$this->currentUser()->id]));
            }else
                $members = [$this->currentUser()->id];
                foreach ($members as $id){
                    $user = $this->user->getById($id);
                    $channel->users()->attach($id, ['display_name' => $user->name, 'status' => Channel::ACTIVE ]);
//                }
            }

            $channel->channel_id = $channel_code;
	        event(new InvitedToChannel($channel, $this->currentUser()));
            return $this->response->withCreated($channel);
        }catch (\Exception $e){
            return $this->response->withForbidden($e->getMessage());
        }
    }

    /**
     * Method GET
     * usage: http://localhost:8000/api/channel/info?id=1
     * get channel information
     * request has channel_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse :list all channels
     */
    public function getChannelInfo(Request $request) {
        try{
        	$channel_id = $request->get('id');
        	if(!$channel_id) {
		        $channel_id = Channel::GENERAL_CHANNEL_ID;
	        }
            $channel = $this->channel->getChannelById($channel_id);
            return $this->response->withCreated($channel);
        }catch (\Exception $e){
            return $this->response->withInternalServer($e->getMessage());
        }
    }

    /**
     * Method GEt
     * usage: http://localhost:8000/api/channel/my
     * get list channel of current user
     * return list channel of current user. except channel blocked
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListChannelOfUser() {
        try {
            $channels = $this->user->takePartInChannels($this->currentUser()->id);

           // dd($channels);
            return $this->response->withArray(Channel::hydrate($channels));
        }catch (\Exception $e){
            return $this->response->withNotFound($e->getMessage());
        }
    }

    /**
     * Method GET
     * usage: http://localhost:8000/api/channel/list?search_name=2ccd
     * get List Channel
     * if request has 'search_name' return list channel has name like *search_name* else return list all channel
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListChannel(Request $request) {
        try {
            $name = $request->get('search_name');
            $channels = $this->channel->searchByName($name);
            return $this->response->withArray($channels);
        }catch (\Exception $e){
            return $this->response->withNotFound($e->getMessage());
        }
    }

    /**
     * Method PUT
     * usage: http://localhost:8000/api/channel/update
     * $allow = ['type', 'purpose', 'description', 'channel_id']
     * update channel info
     * UpdateChannelRequest validate Channel information before handle
     * @param UpdateChannelRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateChannelRequest $request) {
        try{
            $id = $request->get('id');
            $channel = $this->channel->getById($id);
            if($channel->creator == $this->currentUser()->id) {
                $allow = ['type', 'purpose', 'description', 'channel_id', 'name'];
                $update = array_filter(array_intersect_key($request->all(), array_flip($allow)));
                $this->channel->updateColumn($id, $update);
                $channel = $this->channel->getById($id);
                return $this->response->withUpdated($channel);
            }else{
                return $this->response->withForbidden(trans('messages.user.permission_deny'));
            }
        }catch (\Exception $e){
            return $this->response->withNotFound($e->getMessage());
        }
    }

    /**
     * Method DELETE
     * usage http://localhost:8000/api/channel/destroy?id=14
     * destroy channel
     * request has channel_id
     * require check permission of current user
     * return true if success, else return false
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request) {
        try{
            $id = $request->get('id');
            if($id) {
	            $channel = $this->channel->getChannelById($id);
	            if($channel->creator == $this->currentUser()->id) {
		            $this->channel->destroy($channel->id);
		            event(new ChannelWasDeleted($id));
		            return $this->response->withUpdated($channel);
	            }else{
		            return $this->response->withForbidden(trans('messages.user.permission_deny'));
	            }
            } else {
	            return $this->response->withForbidden(trans('messages.user.permission_deny'));
            }

        }catch (\Exception $e){
            return $this->response->withBadRequest($e->getMessage());
        }
    }

    /**
     * Method PUT
     * usage: http://localhost:8000/api/channel/invite
     * invite a user to specific channel
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function invite(Request $request) {
        try{
            $channelId = $request->get('channel_id');
            if($channelId === Channel::GENERAL_CHANNEL_ID) {
	            return $this->response->withForbidden(trans('messages.user.permission_deny'));
            }
            $invited_users = $request->get('invited_users');
            $channel = $this->channel->getChannelById($channelId);
            if($this->currentUser()->channels->contains($channel) && $invited_users){
            	foreach ($invited_users as $userId) {
		            $user = $this->user->getById($userId);
		            if(!$channel->users->contains('id', $userId)) {
			            $channel->users()->attach($userId, ['display_name' => $user->name, 'status' => Channel::ACTIVE ]);
		            }
	            }
	            $channel = $this->channel->getChannelById($channelId);
	            event(new InvitedToChannel($channel, $this->currentUser()));
                return $this->response->withUpdated($channel);
            }else{
                return $this->response->withForbidden(trans('messages.user.permission_deny'));
            }
        }catch (\Exception $e){
            return $this->response->withBadRequest($e->getMessage());
        }
    }

	/**
	 * Method PUT
	 * usage: http://localhost:8000/api/channel/leave?channel_id=1
	 * invite a user to specific channel
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function leave(Request $request) {
		try{
			$channelId = $request->get('channel_id');
			if($channelId === Channel::GENERAL_CHANNEL_ID) {
				return $this->response->withForbidden(trans('messages.user.permission_deny'));
			}
			$currentUserId = $this->currentUser()->id;
			$channel = $this->channel->getChannelById($channelId);
			if($this->currentUser()->channels->contains($channel)){
				$channel->users()->detach($currentUserId);
				return $this->response->withUpdated($channel);
			}else{
				return $this->response->withForbidden(trans('messages.user.permission_deny'));
			}
		}catch (\Exception $e){
			return $this->response->withBadRequest($e->getMessage());
		}
	}


    /**
     * @method DELETE
     * @usage http://localhost:8000/api/channel/ban?channel_id=1&user_id=2
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse information of banned user
     */
    public function removeUserFromChannel(Request $request){
        $currentUser = $this->currentUser();
        try{
            $channel = $this->channel->getById($request->get('channel_id'));
            if ($channel->creator == $currentUser->id){
                $userId = $request->get('user_id');
                if ($userId == $currentUser->id){
                    return $this->response->withBadRequest('Can not remove yourself!');
                }
                $user = $this->user->getById($userId);
                //remove user from participations table
                $user->channels()->detach();
                // remove post in this channel
                $user->posts()->where('channel_id', $channel->id)->delete();
                return $this->response->withUpdated($user);
            }else{
                return $this->response->withForbidden(trans('messages.user.permission_deny'));
            }
        }catch(\Exception $e) {
            return $this->response->withInternalServer($e->getMessage());
        }
    }
}

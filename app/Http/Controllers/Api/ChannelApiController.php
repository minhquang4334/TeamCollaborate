<?php

namespace App\Http\Controllers\Api;

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
	        $str_random = strtoupper(str_random(config('const.length_channel_code')));
            $channel = $this->channel->store(array_merge($request->all(), [
                'creator' => $this->currentUser()->id,
                'status'  => Channel::ACTIVE,
            ]));
            $channel_code = $str_random.$channel->id;
			      $this->channel->updateColumn($channel->id, ['channel_id' => $channel_code]);
            if($request->has('invited_users')){
                $members = array_merge($request->get('invited_users'), [$this->currentUser()->id]);
            }else
                $members = [$this->currentUser()->id];
                foreach ($members as $id){
                    $user = $this->user->getById($id);
                    $channel->users()->attach($id, ['display_name' => $user->name, 'status' => Channel::ACTIVE ]);
//                }
            }

            $channel->channel_id = $channel_code;
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
            $channel = $this->channel->getChannelById($request->get('id'));
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
            $channel = $this->channel->getById($id);
            if($channel->creator == $this->currentUser()->id) {
                $this->channel->destroy($id);
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
     * usage: http://localhost:8000/api/channel/invite
     * invite a user to specific channel
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function invite(Request $request) {
        try{
            $channelId = $request->get('channel_id');
            $userId = $request->get('user_id');
            $channel = $this->channel->getById($channelId);
            if($this->currentUser()->channels->contains($channel)){
                $user = $this->user->getById($userId);
                $channel->users()->attach($userId, ['display_name' => $user->name, 'status' => Channel::ACTIVE ]);
                return $this->response->withUpdated($channel);
            }else{
                return $this->response->withForbidden(trans('messages.user.permission_deny'));
            }
        }catch (\Exception $e){
            return $this->response->withBadRequest($e->getMessage());
        }
    }
}

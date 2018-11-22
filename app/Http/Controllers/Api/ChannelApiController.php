<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\CreateChannelRequest;
use App\Http\Requests\User\UpdateChannelRequest;
use App\Model\Channel;
use App\Repositories\ChannelRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
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
     * usage: http://localhost:8000/api/channel/create?token={{jwt}}&type=1&purpose=For study&description=This is my Foa&channel_id=hahha
     * add new channel
     * return new channel information if success, else return error message
     * @param CreateChannelRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateChannelRequest $request) {
        try{
            $channel = $this->channel->store(array_merge($request->all(), [
                'creator' => Auth::guard('api')->user()->id,
                'status'  => 1,
            ]));
            return response()->json(['status' => true, 'data' => $channel], self::CODE_CREATE_SUCCESS);
        }catch (\Exception $e){
            return response()->json(['status' => false, 'data' => $e->getMessage()], self::CODE_BAD_REQUEST);
        }
    }

    /**
     * Method GET
     * usage: http://localhost:8000/api/channel/info?token={{jwt}}&id=1
     * get channel information
     * request has channel_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse :list all channels
     */
    public function getChannelInfo(Request $request) {
            try{
                $channel = $this->channel->getById($request->get('id'));
                return response()->json(['status' => true, 'data' => $channel], self::CODE_GET_SUCCESS);
            }catch (\Exception $e){
                return response()->json(['status' => false, 'data' => $e->getMessage()], self::CODE_INTERNAL_ERROR);
            }
    }

    /**
     * Method GEt
     * usage: http://localhost:8000/api/channel/my?token={{jwt}}
     * get list channel of current user
     * return list channel of current user. except channel blocked
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListChannelOfUser() {
        try {
            $channels = $this->user->takePartInChannels(Auth::guard('api')->user()->id);
            return response()->json(['status' => true, 'data' => $channels], self::CODE_GET_SUCCESS);
        }catch (\Exception $e){
            return response()->json(['status' => false, 'data' => $e->getMessage()], self::CODE_BAD_REQUEST);
        }
    }

    /**
     * Method GET
     * usage: http://localhost:8000/api/channel/list?token={{jwt}}&search_name=2ccd
     * get List Channel
     * if request has 'search_name' return list channel has name like *search_name* else return list all channel
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListChannel(Request $request) {
        try {
            $name = $request->get('search_name');
            $channels = $this->channel->searchByName($name);
            return response()->json(['status' => true, 'data' => $channels], self::CODE_GET_SUCCESS);
        }catch (\Exception $e){
            return response()->json(['status' => false, 'data' => $e->getMessage()], self::CODE_BAD_REQUEST);
        }
    }

    /**
     * Method PUT
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
            if($channel->creator == Auth::guard('api')->user()->id) {
                $allow = ['type', 'purpose', 'description', 'channel_id'];
                $update = array_filter(array_intersect_key($request->all(), array_flip($allow)));
                $success = $this->channel->updateColumn($id, $update);
                $channel = $this->channel->getById($id);
                return response()->json(['status' => $success, 'data' => $channel], self::CODE_UPDATE_SUCCESS);
            }else{
                return response()->json(['status' => false, 'data' => 'Permission deny'], self::CODE_METHOD_NOT_ALLOWED);
            }
        }catch (\Exception $e){
            return response()->json(['status' => false, 'data' => $e->getMessage()], self::CODE_INTERNAL_ERROR);
        }
    }

    /**
     * Method DELETE
     * usage http://localhost:8000/api/channel/destroy?token={{jwt}}&id=14
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
            if($channel->creator == Auth::guard('api')->user()->id) {
                $success = $this->channel->destroy($id);
                return response()->json(['status' => $success, 'data' => $channel], self::CODE_UPDATE_SUCCESS);
            }else{
                return response()->json(['status' => false, 'data' => 'Permission deny'], self::CODE_METHOD_NOT_ALLOWED);
            }
        }catch (\Exception $e){
            return response()->json(['status' => false, 'data' => $e->getMessage()], self::CODE_INTERNAL_ERROR);
        }
    }

    /**
     * Method GET
     * invite a user to specific channel
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function invite(Request $request) {
            try{
                $channelId = $request->get('channel_id');
                $userId = $request->get('user_id');
                $channel = $this->channel->getById($channelId);
                if(Auth::guard('api')->user()->channels->contains($channel)){
                    $user = $this->user->getById($userId);
                    $channel->users()->attach($userId, ['display_name' => $user->name, 'status' => 0 ]);
                    return response()->json(['status' => true, 'data' => $channel], self::CODE_UPDATE_SUCCESS);
                }else{
                    return response()->json(['status' => false, 'data' => 'Permission deny'], self::CODE_METHOD_NOT_ALLOWED);
                }
            }catch (\Exception $e){
                return response()->json(['status' => false, 'data' => $e->getMessage()], self::CODE_INTERNAL_ERROR);
            }
    }
}

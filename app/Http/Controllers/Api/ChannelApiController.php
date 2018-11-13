<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\UpdateChannelRequest;
use App\Repositories\ChannelRepository;
use Illuminate\Support\Facades\Request;

class ChannelApiController extends ApiController
{
    protected $channel;

    /**
     * ChannelApiController constructor.
     * @param ChannelRepository $channel
     */
    public function __construct(ChannelRepository $channel)
    {
        parent::__construct();
        $this->channel = $channel;
    }

    /**
     * get channel information
     * request has channel_id
     * return list all channels
     * @param Request $request
     */
    public function getChannelInfo(Request $request) {

    }

    /**
     * get list channel of current user
     * return list channel of current user. except channel blocked
     * @param Request $request
     */
    public function getListChannelOfUser(Request $request) {

    }

    /**
     * get List Channel
     * if request has 'search_name' return list channel has name like *search_name* else return list all channel
     * @param Request $request
     */
    public function getListChannel(Request $request) {

    }

    /**
     * update channel info
     * UpdateChannelRequest validate Channel information before handle
     * @param UpdateChannelRequest $request
     */
    public function update(UpdateChannelRequest $request) {

    }

    /**
     * destroy channel
     * request has channel_id
     * require check permission of current user
     * return true if success, else return false
     * @param Request $request
     */
    public function destroy(Request $request) {

    }

}

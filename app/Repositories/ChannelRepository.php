<?php

namespace App\Repositories;

use App\Model\Channel;
use Illuminate\Support\Facades\Auth;

class ChannelRepository {
    use BaseRepository;
    //

    protected $model;

    /**
     * Constructor
     *
     * @param Channel $channel
     */

    public function __construct(Channel $channel)
    {
        $this->model = $channel;
    }

    public function updateStatus($status, $id){
        $channel = $this->getById($id);
        $channel->status = $status;
        $this->update($id,$channel->toArray());
        return $status;
    }

    public function getChannelById($id)
    {
        return $this->model->where('channel_id', $id)->first();
    }

    public function searchByName($name){
        return $this->getByLike('name', $name)->get();
    }

    public function findSameChannelWithDirectMessage($invited_users) {
    	$allChannel = $this->model->with('users')->get();
    	foreach ($allChannel as $channel) {
		    $userId = array_column($channel->users()->get()->toArray(), 'id');
		    sort($invited_users);
		    sort($userId);
		    $arraysAreEqual = ($invited_users == $userId);
    		if($arraysAreEqual && ($channel->type === Channel::PROTECTED)) {
    			return $channel->id;
		    }
	    }
	    return false;
    }
}

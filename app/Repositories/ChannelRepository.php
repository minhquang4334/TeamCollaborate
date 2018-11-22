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

    public function getByLike($field, $val){
        return $this->model->where($field, 'like', '%' . $val . '%');
    }
    public function searchByName($name){
        return $this->getByLike('channel_id', $name)->get();
    }
}

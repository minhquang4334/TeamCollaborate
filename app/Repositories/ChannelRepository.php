<?php

namespace App\Repositories;

use App\model\Channel;
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

}
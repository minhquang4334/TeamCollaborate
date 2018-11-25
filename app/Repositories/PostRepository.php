<?php

namespace App\Repositories;

use App\Model\Notification;
use App\Model\Post;
use Illuminate\Support\Facades\Auth;
use Mockery\Matcher\Not;

class PostRepository {
    use BaseRepository;
    //

    protected $model;

    /**
     * Constructor
     *
     * @param Post $post
     */

    public function __construct(Post $post)
    {
        $this->model = $post;
    }

    public function list($channelId, $number, $limit = 10, $sort = 'desc', $sortColumn = 'created_at'){
        return $this->model->where('channel_id', $channelId)->limit($limit)->offset($number)->orderBy($sortColumn, $sort)->get();
    }

}

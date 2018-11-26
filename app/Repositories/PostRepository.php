<?php

namespace App\Repositories;

use App\Model\Follow;
use App\Model\Post;

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

    public function removeFollower($post_id, $user_id){
        return $this->getById($post_id)->followers()->where('user_id', $user_id)->get()->each->delete();
    }

    public function addFollower($post_id, $user_id){
        $follow = new Follow();
        if($follow->where('post_id', $post_id)->where('user_id', $user_id)->count() == 0) {
            $follow->fill(['post_id' => $post_id,
                'user_id' => $user_id]);
            $follow->save();
        }
        return $follow;
    }

}

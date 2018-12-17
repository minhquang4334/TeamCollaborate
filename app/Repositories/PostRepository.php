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

    public function list($channelId, $number = 10, $limit = 10, $sort = 'desc', $sortColumn = 'created_at'){
    	return $this->model->where('is_parent', 0)->where('channel_id', $channelId)->orderBy($sortColumn, $sort)->get()->toArray();
    }

	public function listComment($post_id){
		return $this->getById($post_id)->children()->orderBy('created_at', 'asc')->get()->toArray();
	}

    public function removeFollower($post_id, $user_id){
        $post =  $this->getById($post_id);
        return $post->followers()->where('user_id', $user_id)->get();//->each->delete();
    }

    /**
     * @param $post_id
     * @param $user_id
     * @return Follow
     */
    public function addFollower($post_id, $user_id) {
        $follow = new Follow();
        if($this->getById($post_id)->is_parent && ($follow->where('post_id', $post_id)->where('user_id', $user_id)->count() == 0)) {
            $follow->fill(['post_id' => $post_id,
                'user_id' => $user_id]);
            $follow->save();
        }
        return $follow;
    }

    public function listUserFollowers($post_id) {
    	dd($this->getById($post_id)->followers);
    	return $this->getById($post_id)->followers;
    }

}

<?php

namespace App\Repositories;

use App\model\Notification;
use App\model\Post;
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

}
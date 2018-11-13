<?php

namespace App\Http\Controllers\Api;

use App\Repositories\PostRepository;
use Illuminate\Support\Facades\Request;

class PostApiController extends ApiController
{
    protected $post;

    /**
     * PostApiController constructor.
     * @param PostRepository $post
     */
    public function __construct(PostRepository $post)
    {
        parent::__construct();
        $this->post = $post;
    }

    public function getThread($channel_id, $number_items, $limit = 10) {

    }

    public function getPinnedThread(Request $request) {

    }

    public function reactThread(Request $request) {

    }

    public function addNewThread() {

    }

    public function destroyThread() {

    }

    public function unFollowThread() {

    }

    public function pinThread() {

    }

    public function editThread() {

    }





}

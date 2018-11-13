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

    /**
     * get List Thread in Specific channel
     * $number_items is number of threads loaded
     * @param $channel_id
     * @param $number_items
     * @param int $limit
     * @return response($data, status_code)
     * @example response([status: true, data: [user_id: 1, user_name: hajau]], HTTP_OK)
     */
    public function getList($channel_id, $number_items, $limit = 10) {

    }

    /**
     * get pinned thread in specific channel
     * return list
     * @param Request $request
     */
    public function getPinned(Request $request) {

    }

    /**
     * add new thread in specific channel
     * check in thread has tagged user, handle this
     * return new thread information
     */
    public function add() {

    }

    /**
     * destroy a thread
     * return true if success, else return false
     */
    public function destroy() {

    }

    /**
     * unfollow a thread
     * return true if success, else return false and message
     */
    public function unFollow() {

    }

    /**
     * pin a thread to a channel
     * return true if success, else return false
     */
    public function pin() {

    }

    /**
     * edit a thread
     * return new information of thread
     * update tagged user list, if it was changed
     */
    public function update() {

    }

    /**
     * report a thread
     * return report information
     */
    public function report() {

    }

}

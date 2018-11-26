<?php

namespace App\Http\Controllers\Api;

use App\Model\Post;
use App\Repositories\ChannelRepository;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;

class PostApiController extends ApiController
{
    protected $post;
    protected $channel;
    protected $number_post_limit;
    /**
     * PostApiController constructor.
     * @param PostRepository $post
     * @param ChannelRepository $channel
     */
    public function __construct(PostRepository $post, ChannelRepository $channel)
    {
        parent::__construct();
        $this->post = $post;
        $this->channel = $channel;
    }

    /**
     * Method GET
     * @usage http://localhost:8000/api/post/list?channel_id=1&limit=2&number_items=2
     * get List Thread in Specific channel
     * $number_items is number of threads loaded
     * @param Request $request * $channel_id, $number_items, $limit = number_post_limit
     * @return \Illuminate\Http\JsonResponse response($data, status_code) response($data, status_code)
     * @example response([status: true, data: [user_id: 1, user_name: hajau]], HTTP_OK)
     */
    public function getList(Request $request) {
        try{
            $channelId = $request->get('channel_id');
            $number = $request->get('number_items');
            $limit = $request->has('limit')?$request->get('limit'):$this->number_post_limit;
            $channel = $this->channel->getById($channelId);
            $user = $this->currentUser();
            if($user->channels->contains($channel)) {
                $posts = $this->post->list($channelId, $number, $limit);
                return response()->json(['status' => true, 'data' => $posts], self::CODE_UPDATE_SUCCESS);
            }else{
                return response()->json(['status' => false, 'data' => trans('messages.user.not_in_channel')], self::CODE_UNAUTHORIZED);
            }
        }catch (\Exception $e){
            return response()->json(['status' => false, 'data' => $e->getMessage()], self::CODE_INTERNAL_ERROR);
        }
    }

    /**
     * Method GET
     *
     * get pinned thread in specific channel
     * return list
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPinned(Request $request) {
        try{
            $channelId = $request->get('channel_id');
            $channel = $this->channel->getById($channelId);
            $user = $this->currentUser();
            if($user->channels->contains($channel)) {
                $posts = $channel->pinned();
                return response()->json(['status' => true, 'data' => $posts], self::CODE_UPDATE_SUCCESS);
            }else{
                return response()->json(['status' => false, 'data' => trans('messages.user.not_in_channel')], self::CODE_UNAUTHORIZED);
            }
        }catch (\Exception $e){
            return response()->json(['status' => false, 'data' => $e->getMessage()], self::CODE_INTERNAL_ERROR);
        }
    }

    /**
     * Method post
     * @usage http://localhost:8000/api/post/list?channel_id=1&content=hello%20everyone
     * add new thread in specific channel
     * store file
     * check in thread has tagged user, handle this
     * return new thread information
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request) {
        try {
            $user = $this->currentUser();
            $channel = $this->channel->getById($request->get('channel_id'));
            if($user->channels->contains($channel)) {
                $allow = ['content', 'channel_id'];
                $input = array_filter(array_intersect_key($request->all(), array_flip($allow)));
                $post = $this->post->store(array_merge($input, [
                    'creator' => $this->currentUser()->id,
                    'status' => Post::ACTIVE,
                ]));
                return response()->json(['status' => true, 'data' => $post], self::CODE_CREATE_SUCCESS);
            }else{
                    return response()->json(['status' => false, 'data' => trans('messages.user.not_in_channel')], self::CODE_UNAUTHORIZED);
                }
        }catch (\Exception $e){
            return response()->json(['status' => false, 'data' => $e->getMessage()], self::CODE_BAD_REQUEST);
        }
    }

    /**
     * Method delete
     * @usage http://localhost:8000/api/post/destroy?id=1
     * destroy a thread
     * remove file in thread
     * remove tagged user in thread
     * return true if success, else return false
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request) {
        try{
            $id = $request->get('id');
            $post = $this->post->getById($id);
            if($post->creator == $this->currentUser()->id) {
                $success = $this->post->destroy($id);
                return response()->json(['status' => $success, 'data' => $post], self::CODE_DELETE_SUCCESS);
            }else{
                return response()->json(['status' => false, 'data' => trans('messages.user.permission_deny')], self::CODE_METHOD_NOT_ALLOWED);
            }
        }catch (\Exception $e){
            return response()->json(['status' => false, 'data' => $e->getMessage()], self::CODE_INTERNAL_ERROR);
        }
    }

    /**
     * unfollow a thread
     * return true if success, else return false and message
     */
    public function unFollow() {

    }

    /**
     * MEthod PUT
     * @usage http://localhost:8000/api/post/pin?post_id=9
     * pin a thread to a channel
     * return true if success, else return false
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pin(Request $request) {
        try {
            $user = $this->currentUser();
            $channelId = $this->post->getById($request->get('post_id'))->channel_id;
            $channel = $this->channel->getById($channelId);
            if($user->channels->contains($channel)) {
                $post = $this->post->updateColumn($request->get('post_id'),[
                    'type' => Post::PINNED,]);
                return response()->json(['status' => true, 'data' => $post], self::CODE_UPDATE_SUCCESS);
            }else{
                return response()->json(['status' => false, 'data' => trans('messages.user.not_in_channel')], self::CODE_UNAUTHORIZED);
            }
        }catch (\Exception $e){
            return response()->json(['status' => false, 'data' => $e->getMessage()], self::CODE_BAD_REQUEST);
        }
    }

    /**
     * Method PUT
     * @usage http://localhost:8000/api/post/list?id=1&content=xxx
     * edit a thread
     * return new information of thread
     * update tagged user list, if it was changed
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request) {
        try{
            $id = $request->get('id');
            $post = $this->post->getById($id);
            if($post->creator == $this->currentUser()->id) {
                $allow = ['content'];
                $update = array_filter(array_intersect_key($request->all(), array_flip($allow)));
                $success = $this->post->updateColumn($id, $update);
                $post = $this->post->getById($id);
                return response()->json(['status' => $success, 'data' => $post], self::CODE_UPDATE_SUCCESS);
            }else{
                return response()->json(['status' => false, 'data' => trans('messages.user.permission_deny')], self::CODE_METHOD_NOT_ALLOWED);
            }
        }catch (\Exception $e){
            return response()->json(['status' => false, 'data' => $e->getMessage()], self::CODE_INTERNAL_ERROR);
        }
    }

    /**
     * report a thread
     * return report information
     */
    public function report() {

    }

}

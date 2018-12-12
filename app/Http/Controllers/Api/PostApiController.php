<?php

namespace App\Http\Controllers\Api;

use App\Model\Post;
use App\Model\Report;
use App\Repositories\ChannelRepository;
use App\Repositories\PostRepository;
use App\Repositories\ReportRepository;
use Illuminate\Http\Request;

class PostApiController extends ApiController
{
    protected $post;
    protected $channel;
    protected $report;
    protected $number_post_limit;
    /**
     * PostApiController constructor.
     * @param PostRepository $post
     * @param ChannelRepository $channel
     * @param ReportRepository $report
     */
    public function __construct(PostRepository $post, ChannelRepository $channel, ReportRepository $report)
    {
        parent::__construct();
        $this->post = $post;
        $this->channel = $channel;
        $this->report = $report;
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
            $channel = $this->channel->getChannelById($channelId);
            $user = $this->currentUser();
            if($user->channels->contains($channel)) {
                $posts = $this->post->list($channel->id, $number, $limit);
                return $this->response->withArray(Post::hydrate($posts));
            }else{
                return $this->response->withForbidden(trans('messages.user.not_in_channel'));
            }
        }catch (\Exception $e){
            return $this->response->withInternalServer($e->getMessage());
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
                return $this->response->withArray($posts);
            }else{
                return $this->response->withForbidden(trans('messages.user.not_in_channel'));
            }
        }catch (\Exception $e){
            return $this->response->withInternalServer($e->getMessage());
        }
    }

    /**
     * Method post
     * @usage http://localhost:8000/api/post/add?channel_id=2&content=hahahaha&tag_users = ['1', '2', '3']&parent_id=2
     * @usage http://localhost:8000/api/post/add?channel_id=2&content=hahahaha&tag_users[]=1&tag_users[]=2
     * @usage http://localhost:8000/api/post/add?channel_id=6&content=hahahaha&tag_users[]= 1&tag_users[]=2&is_parent=1&tag_users[]=3
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
            $channel = $this->channel->getChannelById($request->get('channel_id'));
            if($user->channels->contains($channel->id)) {
                $allow = ['content', 'channel_id', 'parent_id'];
                $input = array_filter(array_intersect_key($request->all(), array_flip($allow)));
                $is_parent = $request->get('parent_id') ? true : false;
                $post = $this->post->store(array_merge([], [
                	'content' => $request->get('content'),
                	'channel_id' => $channel->id,
                    'creator' => $this->currentUser()->id,
                    'status' => Post::ACTIVE,
                    'is_parent' => $is_parent,
                ]));
                if($request->has('tag_users'))
                    $tag_users = array_merge($request->get('tag_users'), [$this->currentUser()->id]);
                else
                    $tag_users = [$this->currentUser()->id];
                foreach ($tag_users as $u){
                    $this->post->addFollower($post->id, $u);
                }
                $post->followers;

                return $this->response->withCreated($post);
            }else{
                return $this->response->withForbidden(trans('messages.user.not_in_channel'));
            }
        }catch (\Exception $e){
            return $this->response->withInternalServer($e->getMessage());
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
                $this->post->destroy($id);
                return $this->response->withUpdated($post);
            }else{
                return $this->response->withForbidden(trans('messages.user.permission_deny'));
            }
        }catch (\Exception $e){
            return $this->response->withInternalServer($e->getMessage());
        }
    }

    /**
     * @Method PUT
     * @usage http://localhost:8000/api/post/follow?post_id=2&user_id=2
     * unfollow a thread
     * return true if success, else return false and message
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function follow(Request $request) {
        try {
            $userId = $request->get('user_id');
            $postId = $request->get('post_id');
            $follow = $this->post->addFollower($postId, $userId);
            if(!empty($follow)) {
                return $this->response->withMessage(trans('messages.user.follow_success'));
            }else{
                return response()->json(['status' => true, 'data' => trans('messages.user.not_follow')], self::CODE_INTERNAL_ERROR);
            }
        }catch (\Exception $e){
            return $this->response->withInternalServer($e->getMessage());
        }
    }


    /**
     * @Method delete
     * @usage http://localhost:8000/api/post/unfollow?post_id=2&user_id=2
     * unfollow a thread
     * return true if success, else return false and message
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function unFollow(Request $request) {
        try {
            $userId = $request->get('user_id');
            $postId = $request->get('post_id');
            $follow = $this->post->removeFollower($postId, $userId);
            if(!empty($follow)) {
                return $this->response->withMessage(trans('messages.user.unfollow_success'));
            }else{
                return $this->response->withForbidden(trans('messages.user.not_follow'));
            }
        }catch (\Exception $e){
            return $this->response->withInternalServer($e->getMessage());
        }
    }

    /**
     * @Method PUT
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
                return $this->response->withMessage(trans('messages.user.pin_success'));
            }else{
                return $this->response->withForbidden(trans('messages.user.not_in_channel'));
            }
        }catch (\Exception $e){
            return $this->response->withInternalServer($e->getMessage());
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
                $this->post->updateColumn($id, $update);
                $post = $this->post->getById($id);
                return $this->response->withUpdated($post);
            }else{
                return $this->response->withForbidden( trans('messages.user.permission_deny'));
            }
        }catch (\Exception $e){
            return $this->response->withInternalServer($e->getMessage());
        }
    }

    /**
     * @Method post
     * @usage http://localhost:8000/api/post/report?post_id=2&channel_id=1&description=Taji no ngu
     * report a thread
     * return report information
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function report(Request $request) {
        try{
            $report = $this->report->store(array_merge($request->all(), [
                'report_creator_id' => $this->currentUser()->id,
                'status' => Report::YET,
            ]));
            return $this->response->withCreated($report);
        }catch (\Exception $e){
            return $this->response->withInternalServer($e->getMessage());
        }
    }

}

<?php

namespace App\Http\Controllers\Api;

use App\Events\CommentWasBookmarked;
use App\Events\CommentWasCreated;
use App\Events\CommentWasDeleted;
use App\Events\CommentWasPatched;
use App\Model\Channel;
use App\Model\Post;
use App\Model\Report;
use App\Repositories\ChannelRepository;
use App\Repositories\PostRepository;
use App\Repositories\ReactRepository;
use App\Repositories\ReportRepository;
use Illuminate\Http\Request;

class PostApiController extends ApiController
{
    protected $post;
    protected $channel;
    protected $report;
    protected $number_post_limit;
    protected $react;
    /**
     * PostApiController constructor.
     * @param PostRepository $post
     * @param ChannelRepository $channel
     * @param ReportRepository $report
     * @param ReactRepository $react
     */
    public function __construct(PostRepository $post, ChannelRepository $channel, ReportRepository $report, ReactRepository $react)
    {
        parent::__construct();
        $this->post = $post;
        $this->channel = $channel;
        $this->report = $report;
        $this->react = $react;
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
	        $channel_id = $request->get('channel_id');
	        if(!$channel_id) {
		        $channel_id = Channel::GENERAL_CHANNEL_ID;
	        }
            $number = $request->get('number_items');
            $limit = $request->has('limit')?$request->get('limit'):$this->number_post_limit;
            $channel = $this->channel->getChannelById($channel_id);
            $user = $this->currentUser();
            if($user->channels->contains($channel)) {
                $posts = $this->post->list($channel->id, $number, $limit, 'asc');
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
	 * @usage http://localhost:8000/api/post/:id/list-comment?channel_id=1&limit=2&number_items=2
	 * get List Thread in Specific channel
	 * $number_items is number of threads loaded
	 * @param Request $request * $channel_id, $number_items, $limit = number_post_limit
	 * @return \Illuminate\Http\JsonResponse response($data, status_code) response($data, status_code)
	 * @example response([status: true, data: [user_id: 1, user_name: hajau]], HTTP_OK)
	 */
	public function getListComment(Request $request) {
		try{
			$channel_id = $request->get('channel_id');
			if(!$channel_id) {
				$channel_id = Channel::GENERAL_CHANNEL_ID;
			}
			$post_id = $request->get('post_id');
			if($post_id) {
				$channel = $this->channel->getChannelById($channel_id);
				$user = $this->currentUser();
				if($user->channels->contains($channel)) {
					$posts = $this->post->listComment($post_id);
					return $this->response->withArray(Post::hydrate($posts));
				}else{
					return $this->response->withForbidden(trans('messages.user.not_in_channel'));
				}
			} else {
				return $this->response->withForbidden(trans('messages.user.post_not_exist'));
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
	        $is_children = $request->get('parent_id') ? true : false;
	        $check = true;
	        $channel_id = Channel::GENERAL_CHANNEL_ID;
	        if(!$is_children) {
		        $channel_id = $request->get('channel_id');
		        if(!$channel_id) {
			        $channel_id = Channel::GENERAL_CHANNEL_ID;
		        }
	        } else {
		        $channel_id = $this->post->getById($request->get('parent_id'))->channel_id;
		        $channel = $this->channel->getById($channel_id);
		        $channel_id = $channel->channel_id;
	        }
	        $channel = $this->channel->getChannelById($channel_id);

	        $check = $user->channels->unique()->contains('channel_id', $channel->channel_id);
            if($check) {
                $allow = ['content', 'channel_id', 'parent_id'];
                $input = array_filter(array_intersect_key($request->all(), array_flip($allow)));



	            $post = new Post();
                if(!$is_children) {
	                $post = $this->post->store(array_merge([], [
		                'content' => $request->get('content'),
		                'channel_id' => $channel->id,
		                'creator' => $this->currentUser()->id,
		                'status' => Post::ACTIVE,
		                'is_parent' => $is_children,
	                ]));
                } else {
                	if($request->get('parent_id')) {
		                $post = $this->post->store(array_merge([], [
			                'content' => $request->get('content'),
			                'channel_id' => $channel->id,
			                'creator' => $this->currentUser()->id,
			                'status' => Post::ACTIVE,
			                'is_parent' => $is_children,
			                'parent_id' => $request->get('parent_id')
		                ]));
	                }
                }
	            $follow_post_id = $is_children ? $request->get('parent_id') : $post->id;
                if($request->has('tag_users')) {
	                $tag_users = array_merge($request->get('tag_users'), [$this->currentUser()->id]);
	                foreach ($tag_users as $u) {
		                $this->post->addFollower($follow_post_id, $u);
	                }
                }
	            $this->post->addFollower($follow_post_id, $this->currentUser()->id);
	            $post->followers;
				event(new CommentWasCreated($post, $this->currentUser(), null));
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
     * @usage http://localhost:8000/api/post/destroy?post_id=1
     * destroy a thread
     * remove file in thread
     * remove tagged user in thread
     * return true if success, else return false
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request) {
        try{
            $id = $request->get('post_id');
            if($id) {
	            $post = $this->post->getById($id);
	            if($post->creator == $this->currentUser()->id) {
		            if(!$post->is_parent) {
			            $post->children()->delete();
		            }
		            $channel_id = $post->channel_id;
		            $channel = new Channel();
		            $channel = $channel->findOrFail($channel_id);
		            $this->post->destroy($id);
		            event(new CommentWasDeleted($id, $this->currentUser(), $channel->channel_id));
		            return $this->response->withUpdated($post);
	            }else{
		            return $this->response->withForbidden(trans('messages.user.permission_deny'));
	            }
            }
	        return $this->response->withForbidden(trans('messages.user.permission_deny'));
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
     * @usage http://localhost:8000/api/post/pin?post_id=9&type=1
     * pin a thread to a channel
     * return true if success, else return false
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pin(Request $request) {
        try {
            $user = $this->currentUser();
            $post = $this->post->getById($request->get('post_id'));
            if($post->id) {
	            $channelId = $post->channel_id;
	            $channel = $this->channel->getById($channelId);
	            if($user->channels->contains($channel)) {
	            	$type = ($request->get('type') === 1) ? Post::PINNED : Post::NORMAL;
		            $post = $this->post->updateColumn($post->id,[
			            'type' => $type,]);
		            $post = $this->post->getById($request->get('post_id'));
		            event(new CommentWasBookmarked($post, $user, null));
		            return $this->response->withMessage(trans('messages.user.pin_success'));
	            }else{
		            return $this->response->withForbidden(trans('messages.user.not_in_channel'));
	            }
            }
	        return $this->response->withForbidden( trans('messages.user.post_not_exist'));
        }catch (\Exception $e){
            return $this->response->withInternalServer($e->getMessage());
        }
    }

    /**
     * Method PUT
     * @usage http://localhost:8000/api/post/edit?id=1&content=xxx
     * edit a thread
     * return new information of thread
     * update tagged user list, if it was changed
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request) {
        try{
            $id = $request->get('post_id');
            $post = $this->post->getById($id);
            if($post->creator == $this->currentUser()->id) {
                $allow = ['content'];
                $update = array_filter(array_intersect_key($request->all(), array_flip($allow)));
                $this->post->updateColumn($id, $update);
                $post = $this->post->getById($id);
                event(new CommentWasPatched($post, $this->currentUser(), null));
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
     * @usage http://localhost:8000/api/post/report?post_id=2&description=Taji no ngu
     * report a thread
     * return report information
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function report(Request $request) {
        try{
	        $post_id = $request->get('post_id');
        	if($post_id) {
		        $description = $request->get('description') ? $request->get('description') : '';
		        $subject = $request->get('subject') ? $request->get('subject') : '';
		        $channel_id = $this->post->getById($post_id)->channel_id;
		        $report = $this->report->store(array_merge($request->all(), [
			        'report_creator_id' => $this->currentUser()->id,
			        'status' => Report::YET,
			        'description' => $description,
			        'subject' => $subject,
			        'channel_id' => $channel_id,
			        'post_id' => $post_id
		        ]));
		        return $this->response->withCreated($report);
	        }
	        return $this->response->withForbidden( trans('messages.user.post_not_exist'));
        }catch (\Exception $e){
            return $this->response->withInternalServer($e->getMessage());
        }
    }

	/**
	 * @Method post
	 * @usage http://localhost:8000/api/post/like?post_id=2&react_code='like'
	 * report a thread
	 * return report information
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
    public function like(Request $request) {
	    try{
		    $post_id = $request->get('post_id');
		    $react_code = $request->get('react_code') ? $request->get('react_code') : 'like';
		    $user_id = $this->currentUser()->id;
		    if($post_id) {
		    	$same_react_id = $this->react->isHaveSameUserReact($user_id, $post_id, $react_code);
			    if($same_react_id) {
			    	$react = $this->react->getById($same_react_id);
				    $react->destroy($same_react_id);
				    return $this->response->withUpdated($react);
			    } else {
				    $react = $this->react->store(array_merge($request->all(), [
					    'user_id' => $user_id,
					    'react_code' => $react_code,
					    'post_id' => $post_id
				    ]));
				    return $this->response->withCreated($react);
			    }
		    }
		    return $this->response->withForbidden( trans('messages.user.post_not_exist'));
	    }catch (\Exception $e){
		    return $this->response->withInternalServer($e->getMessage());
	    }
    }

}

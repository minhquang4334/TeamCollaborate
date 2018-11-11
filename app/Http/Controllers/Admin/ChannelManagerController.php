<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ChannelRepository;

class ChannelManagerController extends Controller
{
    protected $channel;

    public function __construct(ChannelRepository $channel)
    {
        $this->channel = $channel;
    }

    public function index(){
        $channels = $this->channel->all();
        return view('admin.channels', compact('channels'));
    }

    public function updateStatus(Request $request){
        $status = $request->get('status');
        $id=$request->get('id');
        $status = $this->channel->updateStatus($status,$id);
        return response()->json(['data'=>$status], self::CODE_UPDATE_SUCCESS);
    }

    public function detail($id){
        $channel = $this->channel->getById($id);
        $channel->getCreator;
        foreach ($channel->files as $file){
            $file->creator = $file->user;
        }
        $channel->members_count = $channel->getUsersCount();
        $channel->posts_count = $channel->getPostsCount();
        return response()->json(['data'=>$channel], self::CODE_GET_SUCCESS);
    }

    public function delete($id){
        $status = $this->channel->destroy($id);
        return response()->json(['data'=> $status ], self::CODE_DELETE_SUCCESS);
    }
}

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
        $this->channel->updateStatus($status,$id);
        return response()->json(['data'=>$status], 200);
    }

    public function detail($id){
        $channel = $this->channel->getById($id);
        $channel->getCreator;
        return response()->json(['data'=>$channel]);
    }

    public function delete($id){
        $channel = $this->channel->getById($id);
        $channel->delete();
        return response()->json(['data'=> 1 ], 200);
    }
}

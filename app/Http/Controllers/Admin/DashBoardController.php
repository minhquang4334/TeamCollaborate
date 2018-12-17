<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\ChannelRepository;
use App\Repositories\FileRepository;
use App\Repositories\PostRepository;
use App\Repositories\ReportRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use stdClass;

class DashBoardController extends Controller
{
    protected $user;
    protected $channel;
    protected $file;
    protected $report;
    protected $post;
    public function __construct(UserRepository $user, ChannelRepository $channel,
                                FileRepository $file, ReportRepository $report, PostRepository $post)
    {
        $this->user = $user;
        $this->channel = $channel;
        $this->file = $file;
        $this->report = $report;
        $this->post = $post;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $count = new stdClass();;
        $count->user = $this->user->getNumber();
        $count->channel = $this->channel->getNumber();
        $count->file = $this->file->getNumber();
        $count->report = $this->report->getNumber();
        return view('admin.dashboard', ['count' => $count]);
    }

    public function getChart(Request $request){
        $type = $request->get('type');
        $model = $request->get('model');
        $data = $this->$model->getChart($type);
        return response()->json(['data' => $data], self::CODE_GET_SUCCESS);
    }
}

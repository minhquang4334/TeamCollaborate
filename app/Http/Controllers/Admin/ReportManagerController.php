<?php

namespace App\Http\Controllers\Admin;

use App\Model\Post;
use App\Model\Report;
use App\Model\User;
use App\Repositories\PostRepository;
use App\Repositories\ReportRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportManagerController extends Controller
{
    protected $report;
    protected $post;
    protected $user;
    public function __construct(ReportRepository $report, PostRepository $post, UserRepository $user)
    {
        $this->report = $report;
        $this->post = $post;
        $this->user =$user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = $this->report->all();
        return view('admin.reports', compact('reports'));
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $action = $request->input('action');
        $report = $this->report->getById($id);
        if ($action == 1){
            //Block post
            $this->post->updateColumn($report->post_id,['status' => Post::BLOCK]);
            // Notify to user
            (new User())->setEmail($report->creator->email)->sendReportAcceptedNotification();
            (new User())->setEmail($this->user->getById($report->post->creator)->email)->sendReportedNotification();

        }
        $this->report->updateColumn($id, ['status' => Report::RESOLVED]);
        return response()->json(['data'=> $action], self::CODE_UPDATE_SUCCESS);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = $this->report->destroy($id);
        return response()->json(['data'=> $status ], self::CODE_DELETE_SUCCESS);
    }
}

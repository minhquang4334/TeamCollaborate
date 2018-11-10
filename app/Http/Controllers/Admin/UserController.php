<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function index(){
        $users = $this->user->all();
        return view('admin.users', compact('users'));
    }

    public function updateStatus(Request $request){
        $status = $request->get('status');
        $id=$request->get('id');
        $this->user->updateStatus($status,$id);
        return response()->json(['data'=>$status], 200);
    }

    public function detail($id){
        $user = $this->user->getById($id);
        return response()->json(['data'=>$user]);
    }

}

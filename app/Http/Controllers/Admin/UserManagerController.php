<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class UserManagerController extends Controller
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
        $status = $this->user->updateStatus($status,$id);
        return response()->json(['data'=>$status], self::CODE_UPDATE_SUCCESS);
    }

    public function detail($id){
        $user = $this->user->getById($id);
        return response()->json(['data'=>$user], self::CODE_GET_SUCCESS);
    }
}

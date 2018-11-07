<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Hash;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller {

    public function showChangePasswordForm() {
        if (Auth::guard('admin')->user()) {
            return view('admin.auth.change_password');
        }else {
            return redirect('admin/login');
        }

    }
    public function changePassword(Request $request){
        if (!(Hash::check($request->get('current-password'), Auth::guard('admin')->user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        if(strcmp($request->get('new-password'), $request->get('new-password_confirmation')) != 0){
            //Current password and new password are same
            return redirect()->back()->with("error","Password confirmation must be same as your new password. Please try again.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);

        //Change Password
        $user = Auth::guard('admin')->user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect()->back()->with("success","Password changed successfully !");
    }
}

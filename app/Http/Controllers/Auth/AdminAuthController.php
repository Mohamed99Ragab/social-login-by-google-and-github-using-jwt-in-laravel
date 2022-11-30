<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{


    public function AdminLogin(){

        return view('Admin_auth.login');
    }


    public function AdminLoginCheck(Request $request){

        $request->validate([
            'email'=>'required|email|exists:admins,email',
            'password'=>'required|min:6'
        ]);


        if(Auth::guard('admin')->attempt(['email'=>$request->email,'password'=>$request->password])){

            $admin = Admin::where('email',$request->email)->first();

            auth('admin')->login($admin);
            return redirect(route('admin.dashboard'));
        }

        return redirect()->back()->withErrors(['error'=>'email or password not correct']);

    }



}

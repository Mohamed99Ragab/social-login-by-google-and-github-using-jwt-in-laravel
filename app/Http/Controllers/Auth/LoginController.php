<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

    }




    public function github_redirect(){



        return Socialite::driver('github')->redirect();
    }

    public function github_callback(){


        $user = Socialite::driver('github')->user();
//        dd($user);
        $name = $user->nickname;
        $email = $user->email;

       $user_db = User::where('email',$email)->first();
       if($user_db == null){
           $user_db =  User::create([
               'name'=>$name,
               'avatar'=>$user->avatar,
               'email'=>$email,
               'password'=>Hash::make('123456'),
               'OAth_Token' => $user->token
           ]);

           Auth::login($user_db);
           return redirect(route('home'));
       }
       else{
           Auth::login($user_db);
           return redirect(route('home'));
       }

    }


    public function google_redirect(){



        return Socialite::driver('google')->redirect();
    }

    public function google_callback(){


        $user = Socialite::driver('google')->user();
//        dd($user);

        $user_db = User::where('email',$user->email)->first();
        if($user_db == null){
            $user_db =  User::create([
                'name'=>$user->name,
                'avatar'=>$user->avatar,
                'email'=>$user->email,
                'password'=>Hash::make('123456'),
                'OAth_Token' => $user->token
            ]);

            Auth::login($user_db);
            return redirect(route('home'));
        }
        else{
            Auth::login($user_db);
            return redirect(route('home'));
        }

    }












}

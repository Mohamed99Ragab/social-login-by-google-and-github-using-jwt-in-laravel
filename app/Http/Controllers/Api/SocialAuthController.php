<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class SocialAuthController extends Controller
{

    private $provider;
    private $access_token;
    private $token;

    public function __construct(Request $request)
    {
        $this->middleware('auth:api', ['except' => ['token']]);
        auth()->setDefaultDriver('api');
        /**
         * Set any expected parameters
         */
        $this->provider = ($request->has('provider') ? $request->get('provider') : false);
        $this->access_token = ($request->has('access_token') ? $request->get('access_token') : false);
    }

    /**
     * Exchanges an access_token from identity providers for an access_token to be used to authenticate the api.jwt auth guard
     * @return \Illuminate\Http\JsonResponse
     */



    public function token(Request $request)
    {
        // authenticate the token against the provider
//        return response()->json('hi');
        $user = Socialite::driver($this->provider)->stateless()->userFromToken($this->access_token);
//        dd($user);
        // find or create an authenticated user
        if (!$authenticatedUser = User::where('provider_id', $user->id)->first()) {
            $authenticatedUser = User::create([
                'email' => $user->email,
                'name' => $user->nickname,
                'avatar'=>$user->avatar,
                'password'=>null,
                'provider' => $this->provider,
                'provider_id' => $user->id
            ]);
        }

        // login the user & get an access token for the API
        $this->token = auth()->guard('api')->login($authenticatedUser);

        // respond with the access token
        return $this->respondWithToken($this->token,$authenticatedUser);
    }

    public function respondWithToken($token,$user)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => 'todo',
            'user'=>$user
        ]);
    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use App\Utilities\ProxyRequest;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
       public function __construct(ProxyRequest $proxy)
    {
        $this->proxy = $proxy;
    }

    public function login()
    {
        $user = User::where('email', request('email'))->first();

    abort_unless($user, 404, 'This combination does not exists.');
    abort_unless(
        \Hash::check(request('password'), $user->password),
        403,
        'This combination does not exists.'
    );

    $resp = $success['token'] = $user->createToken('appToken')->accessToken;

      DB::table('users')
                ->where('email',request('email'))
                ->update(['api_token' => $success['token']]);


    return response([
        'token' => $resp,
        'expiresIn' => 20000,
        'user'=>$user,
        'message' => 'You have been logged in',
    ], 200);
 
    }
     /**
     * Register api.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
      $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'phone' => 'required|regex:/[0-9]{10}/',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
          return response()->json([
            'success' => false,
            'message' => $validator->errors(),
          ], 401);
        }
       
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('appToken')->accessToken;

        DB::table('users')
                ->where('id', $user['id'])
                ->update(['api_token' => $success['token']]);


       
    
        return response()->json([
          'success' => true,
          'token' => $success,
          'user' => $user
      ]);

    }
    public function demo()
    {
        echo "hello wordls";
    }
    public function refreshToken()
{
    $resp = $this->proxy->refreshAccessToken();

    return response([
        'token' => $resp->access_token,
        'expiresIn' => $resp->expires_in,
        'message' => 'Token has been refreshed.',
    ], 200);
}
    public function logout(Request $res)
    {
      
      
// $user->revoke();

      if(Auth::user())
      {
        $user = Auth::user(); 
           DB::table('users')
                ->where('id',1)
                ->update(['api_token' => '']);
                return response([
        'message' => 'You have been successfully logged out',
    ], 200);
      }
      else
      {
         return response([
        'message' => 'Login First',
    ], 402);
      }
    
      }
}

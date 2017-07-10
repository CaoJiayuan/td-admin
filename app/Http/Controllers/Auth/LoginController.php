<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
  protected $redirectTo = '/';

  protected function sendLoginResponse(Request $request)
  {
    $this->clearLoginAttempts($request);

    return $this->authenticated($request, $this->guard()->user());
  }

  protected function authenticated(Request $request, $user)
  {
    $token = \JWTAuth::fromUser($user);

    $user->token = $token;

    return $user->toArray();
  }

  protected function sendFailedLoginResponse(Request $request)
  {
      return response()->json(['code' => 422,'errors' => [], 'message' => '用户名或密码错误'], 422);
  }
}

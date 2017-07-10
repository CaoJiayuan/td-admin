<?php

namespace App\Http\Middleware;

use App\Traits\ApiAuthenticate;
use Closure;
use Illuminate\Auth\AuthenticationException;

class Authenticate
{
  use ApiAuthenticate;

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure $next
   * @return mixed
   * @throws AuthenticationException
   */
  public function handle($request, Closure $next)
  {
    $user = $this->getUser();
    if (!$user) {
      throw new AuthenticationException();
    }
    \Auth::setUser($user);

    return $next($request);
  }
}

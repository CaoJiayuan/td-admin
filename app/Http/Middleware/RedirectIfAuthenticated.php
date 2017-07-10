<?php

namespace App\Http\Middleware;

use App\Traits\ApiAuthenticate;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
  use ApiAuthenticate;

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure $next
   * @param  string|null $guard
   * @return mixed
   */
  public function handle($request, Closure $next, $guard = null)
  {
    if (Auth::guard($guard)->check()) {
      return redirect('/');
    }

    return $next($request);
  }
}
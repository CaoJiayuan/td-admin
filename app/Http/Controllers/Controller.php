<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  public function getValidatedData($keys)
  {
    /** @var Request $request */
    $request = app(Request::class);
    $rules = [];
    $k = [];
    foreach ($keys as $key => $rule) {
      if (is_numeric($key)) {
        $k[] = $rule;
      } else {
        $k[] = $key;
        $rules[$key] = $rule;
      }
    }
    $this->validate($request, $rules);

    return $request->only($k);
  }

  public function respondSuccess($message = 'Success')
  {
    throw new HttpException(200, $message);
  }
}

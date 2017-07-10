<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-2-23
 * Time: 下午4:06
 */

namespace App\Traits;


trait ApiAuthenticate
{
  public function getUser()
  {
    try {
      $user = \JWTAuth::parseToken()->toUser();
    } catch (\Exception $exception) {
      \Auth::logout();
      return false;
    }
    return $user;
  }
}
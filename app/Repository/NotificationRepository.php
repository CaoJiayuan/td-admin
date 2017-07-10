<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-3-13
 * Time: 上午10:42
 */

namespace App\Repository;


use App\Entity\Notifiation;
use App\Traits\TimerPush;
use Carbon\Carbon;

class NotificationRepository extends Repository
{
  use TimerPush;

  public function create($time, $data)
  {
    return \DB::transaction(function () use ($time, $data) {
      $this->dispatch($time, $data);
      $data['publish_at'] = Carbon::createFromTimestamp($time);
      return Notifiation::create($data);
    });
  }
}
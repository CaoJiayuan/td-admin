<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-3-1
 * Time: 下午2:20
 */

namespace App\Repository;

use App\Entity\Flashes;
use Illuminate\Database\Query\Builder;

class FlashRepository extends Repository
{

  public function getFlashes()
  {
    \Request::offsetSet('order','CMD_NEWS_FLASH.pub_time|desc');
    return $this->getSearchAbleData(Flashes::class, [
      'flash_id', 'pub_time', 'flash_sum'
    ], function ($builder) {

      /** @var Builder $builder */
      $builder->select([
        'CMD_NEWS_FLASH.*'
      ]);
      $builder->groupBy('CMD_NEWS_FLASH.flash_id');
    });
  }
}
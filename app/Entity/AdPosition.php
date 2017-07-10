<?php

namespace App\Entity;
use App\Entity\Ad;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\AdPosition
 *
 * @property int $id
 * @property string $name 广告位名称
 * @property bool $status 状态(0-已删除,1-可用)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\AdPosition whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\AdPosition whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\AdPosition whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\AdPosition whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\AdPosition whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $size 图片尺寸
 * @property bool $code 广告位代码
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Ad[] $ads
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\AdPosition whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\AdPosition whereSize($value)
 */
class AdPosition extends Model
{
  protected $hidden = [
    'created_at',
  ];
  public function ads()
  {
    return $this->hasMany(Ad::class);
  }
}

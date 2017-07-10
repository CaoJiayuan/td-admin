<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;



/**
 * App\Entity\User
 *
 * @property int $id 自增ID
 * @property int $version 版本号
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 * @property string $phone 电话
 * @property string $real_name 真名
 * @property string $nick_name 昵称
 * @property string $avatar 头像
 * @property string $address 住址
 * @property int $broker_id 客户经理id
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereBrokerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereCreateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereNickName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereRealName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereUpdateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\User whereVersion($value)
 * @mixin \Eloquent
 */
class User extends Model
{
  protected $table = 'user';
  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->setConnection('mysql');
  }

/**
 * App\Entity\SgeCatalogDetail
 *
 * @mixin \Eloquent
 */

}


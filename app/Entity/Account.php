<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Account
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
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Account whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Account whereAvatar($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Account whereBrokerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Account whereCreateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Account whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Account whereNickName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Account wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Account whereRealName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Account whereUpdateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Account whereVersion($value)
 * @mixin \Eloquent
 */
class Account extends Model
{
  protected $table = 'user';
  public $timestamps = false;
}

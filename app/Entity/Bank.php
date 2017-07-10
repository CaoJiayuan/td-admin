<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Bank
 *
 * @property int $id 自增ID
 * @property string $code code
 * @property string $path 图片URL
 * @property string $comment 说明
 * @property int $is_support 1 支持  0 不支持
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Bank whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Bank whereComment($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Bank whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Bank whereIsSupport($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Bank wherePath($value)
 * @mixin \Eloquent
 */
class Bank extends Model
{
  protected $table = "bank_info";
}

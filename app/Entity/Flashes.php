<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Flashes
 *
 * @property float $ISVALID
 * @property string $createtime
 * @property string $updatetime
 * @property string $flash_id
 * @property string $pub_time
 * @property string $flash_sum
 * @property float $rec_level
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Flashes whereCreatetime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Flashes whereFlashId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Flashes whereFlashSum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Flashes whereISVALID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Flashes wherePubTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Flashes whereRecLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Flashes whereUpdatetime($value)
 * @mixin \Eloquent
 */
class Flashes extends Model
{
  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->setConnection('news');

  }

  protected $table = "CMD_NEWS_FLASH";
  protected $primaryKey = 'flash_id';

  protected $keyType = 'string';

  protected $fillable = [
    'flash_id',
    'pub_time',
    'flash_sum',
  ];

}

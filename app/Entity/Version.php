<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Version
 *
 * @property int $id
 * @property string $content 内容
 * @property string $version 版本号
 * @property bool $type 更新类型0-更新提醒,1-强制更新
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Version whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Version whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Version whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Version whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Version whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Version whereVersion($value)
 * @mixin \Eloquent
 */
class Version extends Model
{
  protected $fillable = ['content', 'version', 'type', 'build'];

  public function getTypeAttribute()
  {
    $type = $this->attributes['type'];

    return $this->findType($type);
  }

  public function findType($t)
  {
    $types = config('versionType', []);
    foreach ($types as $type) {
      if ($type['type'] == $t) {
        return $type;
      }
    }

    return [];
  }
}

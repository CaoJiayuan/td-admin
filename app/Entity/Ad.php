<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use App\Entity\AdPosition;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Entity\Scoop;
use App\Entity\Resource;

/**
 * App\Entity\Ad
 *
 * @property int $id
 * @property string $title 广告标题
 * @property string $img 广告图片
 * @property int $ad_position_id 广告位id
 * @property bool $type 类型(0-链接,1-素材,2-专题)
 * @property string $url 广告链接
 * @property int $resource_id 素材id
 * @property bool $status 0-已删除,1-可用
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Ad whereAdPositionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Ad whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Ad whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Ad whereImg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Ad whereResourceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Ad whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Ad whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Ad whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Ad whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Ad whereUrl($value)
 * @mixin \Eloquent
 * @property \Carbon\Carbon $deleted_at
 * @property string $resource_name 资源名称
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Ad whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Ad whereResourceName($value)
 */
class Ad extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = ['title','type','ad_position_id','url','img','resource_id','resource_name','size'];
}

<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Notifiation
 *
 * @property int $id
 * @property string $title 推送标题
 * @property string $content 推送内容
 * @property string $publish_at 推送时间
 * @property string $url 推送链接
 * @property bool $status 状态(0-已删除,1-已创建,2-已推送)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Notifiation whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Notifiation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Notifiation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Notifiation wherePublishAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Notifiation whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Notifiation whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Notifiation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Notifiation whereUrl($value)
 * @mixin \Eloquent
 * @property bool $type 链接位置
 * @property \Carbon\Carbon $deleted_at
 * @property string $resource_name 资源名称
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Notifiation whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Notifiation whereResourceName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Notifiation whereType($value)
 */
class Notifiation extends Model
{
  use SoftDeletes;
  protected $fillable = ['title', 'content', 'publish_at', 'url', 'status', 'type','resource_name'];
  protected $hidden = ['updated_at', 'published_at'];
  protected $dates = ['deleted_at'];
}

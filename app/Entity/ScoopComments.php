<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\ScoopComments
 *
 * @property int $id
 * @property float $news_id 新闻id
 * @property string $content 内容
 * @property int $user_id 用户id
 * @property bool $type 类型(0-独家专栏,1-新闻资讯)
 * @property bool $status 状态(0-已删除,1-可用)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $parent_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Complaint[] $complaint
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ScoopComments whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ScoopComments whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ScoopComments whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ScoopComments whereNewsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ScoopComments whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ScoopComments whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ScoopComments whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ScoopComments whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ScoopComments whereUserId($value)
 * @mixin \Eloquent
 */
class ScoopComments extends Model
{
  protected $table = "comments";
  protected $primaryId ='id';
  protected $fillable = [
    'id',
    'news_id',
    'content',
    'user_id',
    'type',
    'status',
    'created_at',
    'title',
  ];


  public function complaint()
  {
    return $this->morphMany(Complaint::class, 'comment','type', 'comment_id', 'id');
  }
}

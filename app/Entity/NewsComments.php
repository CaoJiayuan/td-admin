<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Comment
 *
 * @property int $id
 * @property float $news_id 新闻id
 * @property string $content 内容
 * @property int $user_id 用户id
 * @property bool $type 类型(0-独家专栏,1-新闻资讯)
 * @property bool $status 状态(0-已删除,1-可用)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Comment whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Comment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Comment whereNewsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Comment whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Comment whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Comment whereUserId($value)
 * @mixin \Eloquent
 * @property int $parent_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Complaint[] $complaint
 * @property-read \App\Entity\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\NewsComments whereParentId($value)
 */
class NewsComments extends Model
{
  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->setConnection('news');
  }

  protected $table = "comments";
  protected $primaryKey = 'id';

  protected $keyType = 'string';

  protected $fillable = [
    'news_id',
    'content',
    'title_main',
    'user_id',
    'status',
  ];
  public $timestamps =true;

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function complaint()
  {
    return $this->morphMany(Complaint::class, 'comment','type', 'comment_id', 'id');
  }
}

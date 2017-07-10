<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Scoop
 *
 * @property int $id
 * @property string $title 标题
 * @property string $from 来源
 * @property string $summary 摘要
 * @property string $thumbnail 缩略图
 * @property string $content 内容
 * @property int $news_category_id 新闻类别id
 * @property bool $status 发布状态(0-发布中|未审核,1-已审核)
 * @property string $published_at 发布时间
 * @property int $read 阅读量
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $like
 * @property-read \App\Entity\ScoopCategories $category
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Scoop whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Scoop whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Scoop whereFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Scoop whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Scoop whereLike($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Scoop whereNewsCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Scoop wherePublishedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Scoop whereRead($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Scoop whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Scoop whereSummary($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Scoop whereThumbnail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Scoop whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Scoop whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Scoop extends Model
{
  protected $table = "news";
  protected $primaryKey ='id';
  protected $fillable = [
    'id',
    'from',
    'summary',
    'thumbnail',
    'content',
    'published_at',
    'read',
    'title',
    'news_category_id'
  ];
  public $timestamps = true;

  public function category()
  {
   return $this->belongsTo(ScoopCategories::class,'news_category_id','id');
  }

}

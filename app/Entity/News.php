<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\News
 *
 * @property float $ISVALID
 * @property string $createtime
 * @property string $updatetime
 * @property string $news_id
 * @property string $pub_time
 * @property string $news_author
 * @property string $title_main
 * @property float $data_source_id
 * @property string $news_sum
 * @property string $html_txt
 * @property int $read_count 阅读数量
 * @property int $like_count 点赞数量
 * @property int $comment_count 评论数量
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\News whereCommentCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\News whereCreatetime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\News whereDataSourceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\News whereHtmlTxt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\News whereISVALID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\News whereLikeCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\News whereNewsAuthor($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\News whereNewsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\News whereNewsSum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\News wherePubTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\News whereReadCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\News whereTitleMain($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\News whereUpdatetime($value)
 * @mixin \Eloquent
 */
class News extends Model
{
  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->setConnection('news');

  }

  protected $table = "CMD_NEWS_MAIN";
  protected $primaryKey = 'news_id';

  protected $keyType = 'string';

  protected $fillable = [
    'news_id',
    'news_author',
    'title_main',
    'pub_time',
    'title_main',
    'news_sum',
  ];

}

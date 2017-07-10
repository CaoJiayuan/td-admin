<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\NewsCount
 *
 * @property int $id
 * @property float $news_id 新闻id
 * @property int $read 阅读量
 * @property int $like 点赞量
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\NewsCount whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\NewsCount whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\NewsCount whereLike($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\NewsCount whereNewsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\NewsCount whereRead($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\NewsCount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NewsCount extends Model
{
    //
}

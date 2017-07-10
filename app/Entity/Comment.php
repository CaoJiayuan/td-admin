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
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Comment whereParentId($value)
 */
class Comment extends Model
{
    //
}

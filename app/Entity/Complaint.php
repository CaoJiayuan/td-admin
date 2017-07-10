<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Complaint
 *
 * @property int $id
 * @property int $comment_id 评论id
 * @property bool $type 类型0-资讯,1-专栏
 * @property bool $user_id 用户id
 * @property string $content 内容git pu
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $comment
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Complaint whereCommentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Complaint whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Complaint whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Complaint whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Complaint whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Complaint whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Complaint whereUserId($value)
 * @mixin \Eloquent
 */
class Complaint extends Model
{
   Protected $table = 'complaints';
   Protected $primaryKey ='id';
   Protected $fillable =
   [
     'id',
     'comment_id',
     'user_id',
     'comment_in',
     'type',
     'content'
   ];

  public function comment()
  {
    return $this->morphTo('comment','type','comment_id');
  }
}

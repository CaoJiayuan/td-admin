<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use App\Entity\User;

/**
 * App\Entity\Feedback
 *
 * @property int $id
 * @property string $mobile 手机号
 * @property string $content 内容
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $img 图片
 * @property string $email email
 * @property int $user_id 用户id
 * @property-read \App\Entity\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Feedback whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Feedback whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Feedback whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Feedback whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Feedback whereImg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Feedback whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Feedback whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Feedback whereUserId($value)
 * @mixin \Eloquent
 */
class Feedback extends Model
{
  protected $table = 'feedback';

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}

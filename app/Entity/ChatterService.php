<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\ChatterService
 *
 * @property int $id
 * @property int $chatter_id 聊天用户id,客户,关联im_users表
 * @property int $service_id 客服id,客户经理,关联im_users表
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $last_msg_at 上一条消息发送时间
 * @property string $last_msg 上一条消息
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ChatterService whereChatterId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ChatterService whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ChatterService whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ChatterService whereLastMsg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ChatterService whereLastMsgAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ChatterService whereServiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ChatterService whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ChatterService extends Model
{
    //
}

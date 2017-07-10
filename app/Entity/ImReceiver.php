<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\ImReceiver
 *
 * @property int $id
 * @property int $im_message_id 消息id,对应im_messages
 * @property int $receiver_id 消息接受者id,对应im_users
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImReceiver whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImReceiver whereImMessageId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImReceiver whereReceiverId($value)
 * @mixin \Eloquent
 */
class ImReceiver extends Model
{
    //

  public $timestamps = false;
}

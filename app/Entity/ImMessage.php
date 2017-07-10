<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\ImMessage
 *
 * @property int $id
 * @property int $sender_id 发送者id,对应im_users
 * @property bool $type 类型
 * @property string $summary 摘要
 * @property string $msg 消息内容json receiver
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImMessage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImMessage whereMsg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImMessage whereSenderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImMessage whereSummary($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImMessage whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImMessage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ImMessage extends Model
{
    //
}

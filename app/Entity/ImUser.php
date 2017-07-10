<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\ImUser
 *
 * @property int $id
 * @property int $user_id 用户id或客服id
 * @property int $service_id 用户的当前客服id
 * @property string $im_id im ID
 * @property string $im_password im密码
 * @property bool $type 类型(0-用户,1-客服)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $con_id 当前回话id
 * @property string $nick 用户nickname
 * @property string $icon_url 用户头像url
 * @property bool $online 是否在线
 * @property string $device_id 设备号
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImUser whereConId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImUser whereDeviceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImUser whereIconUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImUser whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImUser whereImId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImUser whereImPassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImUser whereNick($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImUser whereOnline($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImUser whereServiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImUser whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ImUser whereUserId($value)
 * @mixin \Eloquent
 */
class ImUser extends Model
{
    //
}

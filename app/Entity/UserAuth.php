<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\UserAuth
 *
 * @property int $id 自增ID
 * @property int $version 版本号
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 * @property string $app_identifier 登录唯一标识（手机号、邮箱、用户名、第三方应用的唯一标识）
 * @property bool $app_identifier_type 登录类型0-平台帐号 1-微信 2-QQ 3-微博
 * @property string $app_credential 登录标识凭证（内部的保存密码，第三方的不保存或保存token）
 * @property string $device_token 设备唯一标识
 * @property string $latest_ip 最近IP
 * @property string $latest_time 最近时间
 * @property int $user_id 关联用户ID
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserAuth whereAppCredential($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserAuth whereAppIdentifier($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserAuth whereAppIdentifierType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserAuth whereCreateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserAuth whereDeviceToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserAuth whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserAuth whereLatestIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserAuth whereLatestTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserAuth whereUpdateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserAuth whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserAuth whereVersion($value)
 * @mixin \Eloquent
 */
class UserAuth extends Model
{
    //
    protected $table = 'user_auth';
}

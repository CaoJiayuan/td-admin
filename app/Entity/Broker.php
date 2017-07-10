<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Entity\Account;
use App\Entity\Branch;


/**
 * App\Entity\Broker
 *
 * @property int $id
 * @property string $broker_name
 * @property string $broker_id
 * @property string $branch_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property bool $status 状态
 * @property \Carbon\Carbon $deleted_at
 * @property bool $sex 性别（0-男，1-女）
 * @property string $cred_num 身份证号
 * @property string $address 联系地址
 * @property string $zip_code 邮编
 * @property string $phone 手机号码
 * @property string $mobile 联系电话
 * @property string $fax 传真号码
 * @property string $email 电子邮箱
 * @property string $operator_code 运营商编号
 * @property string $original_broker_id 用户输入的原始客户经理id
 * @property string $remark 备注
 * @property int $admin_id 后台用户id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Account[] $accountCount
 * @property-read \App\Entity\Branch $branch
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Broker whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Broker whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Broker whereBranchId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Broker whereBrokerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Broker whereBrokerName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Broker whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Broker whereCredNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Broker whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Broker whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Broker whereFax($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Broker whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Broker whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Broker whereOperatorCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Broker whereOriginalBrokerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Broker wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Broker whereRemark($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Broker whereSex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Broker whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Broker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Broker whereZipCode($value)
 * @mixin \Eloquent
 */
class Broker extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $fillable = [
    'broker_name',
    'broker_id',
    'branch_id',
    'sex',
    'cred_num',
    'address',
    'zip_code',
    'phone',
    'mobile',
    'fax',
    'email',
    'operator_code',
    'original_broker_id',
    'admin_id'
  ];
  public function accountCount()
  {
    return $this->hasMany(Account::class);
  }

  public function branch()
  {
    return $this->belongsTo(Branch::class);
  }

}

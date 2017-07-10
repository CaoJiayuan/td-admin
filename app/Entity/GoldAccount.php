<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/7
 * Time: 16:25
 */
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use App\Entity\Bank;
use App\Entity\UserAuth;

/**
 * App\Entity\GoldAccount
 *
 * @property int $id 自增ID
 * @property int $version 版本号
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 * @property string $gold_num 黄金账号
 * @property string $gold_pwd 黄金密码
 * @property string $name 客户姓名
 * @property string $grade_id 客户等级-关联表
 * @property bool $cred_type 证件类型
 * @property string $cred_num 证件号码
 * @property string $cred_path1 证件照片地址1
 * @property string $cred_path2 证件照片地址2
 * @property string $bank_type 银行类型
 * @property string $bank_num 银行帐号
 * @property string $bank_path 银行照片地址
 * @property string $phone 联系电话
 * @property string $address 联系地址
 * @property string $area_code 地区代码
 * @property string $postal_code 邮政编码
 * @property bool $score_riskevaluation 风险测评分数
 * @property string $broker_list 所属客户经理-关联表
 * @property string $cust_type_id 所属客户分组
 * @property string $email 邮箱
 * @property int $user_id 关联用户ID
 * @property string $bk_seq_no 唯一银行流水号
 * @property-read \App\Entity\UserAuth $auth
 * @property-read \App\Entity\Bank $bank
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereAreaCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereBankNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereBankPath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereBankType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereBkSeqNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereBrokerList($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereCreateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereCredNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereCredPath1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereCredPath2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereCredType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereCustTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereGoldNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereGoldPwd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereGradeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount wherePostalCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereScoreRiskevaluation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereUpdateTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\GoldAccount whereVersion($value)
 * @mixin \Eloquent
 */
class GoldAccount extends Model
{
  //
  protected $table = 'gold_account';
  public $timestamps = false;

  public function bank()
  {
    return $this->belongsTo(Bank::class,'bank_type','code');
  }

  public function auth()
  {
    return $this->hasOne(UserAuth::class,'user_id','user_id');
  }
}

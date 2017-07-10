<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\MoneyRecord
 *
 * @property int $id 自增长id
 * @property int $user_id 平台账号id
 * @property int $gold_id 黄金账号id
 * @property string $exch_date 交易日（不同于普通日期，转账所在交易日）
 * @property string $serial_no 转账流水号
 * @property int $access_way 出入金方向(1：存入  2：取出)
 * @property float $exch_bal 转账金额
 * @property string $o_term_type 转账渠道(01：管理端 02：银行柜面 03：交易终端 04：营业厅自助 05：网上银行 06：电话银行 07：手机银行 08：系统 09：清算 10：通讯接口机 11：其他 12：风控服务器 13：认证服务器 14：人工坐席 16：非会员系统 17：手机终端)
 * @property string $bk_plat_date 银行日期
 * @property string $bk_seq_no 银行流水号
 * @property int $in_account_flag 是否入账(1：是  0：否)
 * @property int $check_stat1 复核状态1(1：未复核  2：复核已通过  3：复核不通过  4：已撤销)
 * @property int $check_stat2 复核状态1(1：未复核  2：复核已通过  3：复核不通过  4：已撤销)
 * @property string $bk_rsp_code 银行响应代码
 * @property string $bk_rsp_msg 银行响应消息
 * @property string $o_date 出入金时间
 * @property string $update_date 数据本地更新时间
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MoneyRecord whereAccessWay($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MoneyRecord whereBkPlatDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MoneyRecord whereBkRspCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MoneyRecord whereBkRspMsg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MoneyRecord whereBkSeqNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MoneyRecord whereCheckStat1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MoneyRecord whereCheckStat2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MoneyRecord whereExchBal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MoneyRecord whereExchDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MoneyRecord whereGoldId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MoneyRecord whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MoneyRecord whereInAccountFlag($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MoneyRecord whereODate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MoneyRecord whereOTermType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MoneyRecord whereSerialNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MoneyRecord whereUpdateDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\MoneyRecord whereUserId($value)
 * @mixin \Eloquent
 */
class MoneyRecord extends Model
{
    protected $table = 'money_record';
}

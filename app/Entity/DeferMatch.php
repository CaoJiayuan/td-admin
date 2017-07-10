<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/7
 * Time: 16:25
 */
namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\DeferMatch
 *
 * @property int $id 自增长id
 * @property int $user_id 客户平台账号id
 * @property int $gold_id 客户黄金账号id
 * @property int $inst_id 合约代码 1-Au(T+D)  2-Ag(T+D)  3-mAu(T+D)
 * @property string $exch_date 成交时间
 * @property string $match_no 成交单号
 * @property int $exch_type 交易类型(开多仓-1  开空仓-2  平多仓-3  平空仓-4)
 * @property float $match_price 成交价格
 * @property int $match_amount 成交数量
 * @property int $offset_flag 开平标志(0：开仓  1：平仓  2：强平)
 * @property float $exch_bal 成交金额
 * @property float $exch_fare 交易费用
 * @property float $margin 保证金
 * @property string $term_type 委托渠道(01：管理端 02：银行柜面 03：交易终端 04：营业厅自助 05：网上银行 06：电话银行 07：手机银行 08：系统)
 * @property string $local_order_no 本地报单号
 * @property string $match_date 委托时间
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\DeferMatch whereExchBal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\DeferMatch whereExchDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\DeferMatch whereExchFare($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\DeferMatch whereExchType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\DeferMatch whereGoldId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\DeferMatch whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\DeferMatch whereInstId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\DeferMatch whereLocalOrderNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\DeferMatch whereMargin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\DeferMatch whereMatchAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\DeferMatch whereMatchDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\DeferMatch whereMatchNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\DeferMatch whereMatchPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\DeferMatch whereOffsetFlag($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\DeferMatch whereTermType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\DeferMatch whereUserId($value)
 * @mixin \Eloquent
 */
class DeferMatch extends Model
{
    protected $table = 'defer_match';
}

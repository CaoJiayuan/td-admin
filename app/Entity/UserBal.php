<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\UserBal
 *
 * @property int $id 自增长id
 * @property int $user_id 平台账号id
 * @property int $gold_id 黄金账号本地id
 * @property string $exch_date 交易日
 * @property float $last_bal 上日余额
 * @property float $last_can_use 上日可用
 * @property float $curr_bal 当日余额
 * @property float $curr_can_use 当日可用
 * @property float $curr_can_get 当日可提
 * @property float $last_margin 上日保证金
 * @property float $last_reserve 上日溢短备付金
 * @property float $out_bal 当日出金
 * @property float $in_bal 当日入金
 * @property float $real_buy 成交买入金额
 * @property float $real_sell 成交卖出金额
 * @property float $real_reserve 成交溢短备付金
 * @property float $real_margin 成交保证金
 * @property float $base_margin 当前基础保证金
 * @property float $last_base_margin 上日基础保证金
 * @property float $deli_prepare 当日交割准备金
 * @property float $last_deli_prepare 上日交割准备金
 * @property float $deli_margin 当日交割保证金
 * @property float $last_deli_margin 上日交割保证金
 * @property float $real_exch_fare 当日交易费用
 * @property float $other_fare 其他费用
 * @property float $pay_breach 支付违约金
 * @property float $take_breach 收到违约金
 * @property float $cov_surplus 平仓盈余
 * @property float $mark_surplus 盯市盈余
 * @property float $float_surplus 浮动盈余
 * @property float $last_long_froz 上日冻结资金
 * @property float $day_long_froz 当日冻结资金
 * @property float $last_forward_froz 上日远期盈亏冻结
 * @property float $day_forward_froz 当日远期盈亏冻结
 * @property float $inte_integral 利息积数
 * @property float $puni_integral 罚息积数
 * @property float $wait_incr_inte 待入账利息
 * @property float $wait_incr_inte_tax 待入账利息税
 * @property float $day_incr_inte 当日入账利息
 * @property float $day_incr_inte_tax 当日入账利息税
 * @property float $last_take_margin 上日提货保证金冻结
 * @property float $day_take_margin 当日提货保证金冻结
 * @property float $last_stor_fare_froz 上日仓储费冻结
 * @property float $day_stor_fare_froz 当日仓储费冻结
 * @property string $update_date 数据本地更新时间
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereBaseMargin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereCovSurplus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereCurrBal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereCurrCanGet($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereCurrCanUse($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereDayForwardFroz($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereDayIncrInte($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereDayIncrInteTax($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereDayLongFroz($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereDayStorFareFroz($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereDayTakeMargin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereDeliMargin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereDeliPrepare($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereExchDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereFloatSurplus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereGoldId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereInBal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereInteIntegral($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereLastBal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereLastBaseMargin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereLastCanUse($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereLastDeliMargin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereLastDeliPrepare($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereLastForwardFroz($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereLastLongFroz($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereLastMargin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereLastReserve($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereLastStorFareFroz($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereLastTakeMargin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereMarkSurplus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereOtherFare($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereOutBal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal wherePayBreach($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal wherePuniIntegral($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereRealBuy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereRealExchFare($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereRealMargin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereRealReserve($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereRealSell($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereTakeBreach($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereUpdateDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereWaitIncrInte($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\UserBal whereWaitIncrInteTax($value)
 * @mixin \Eloquent
 */
class UserBal extends Model
{
    protected $table = 'user_bal';
}

<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\LastQuo
 *
 * @property string $inst_id 合约代码
 * @property string $name 合约名称
 * @property float $last_close 昨收
 * @property float $open 开盘价
 * @property float $high 最高价
 * @property float $low 最低价
 * @property float $last 最新价
 * @property float $close 收盘价
 * @property float $bid1 买价1
 * @property int $bid_lot1 买量1
 * @property float $bid2 买价2
 * @property int $bid_lot2 买量2
 * @property float $bid3 买价3
 * @property int $bid_lot3 买量3
 * @property float $bid4 买价4
 * @property int $bid_lot4 买量4
 * @property float $bid5 买价5
 * @property int $bid_lot5 买量5
 * @property float $ask1 卖价1
 * @property int $ask_lot1 卖量1
 * @property float $ask2 卖价2
 * @property int $ask_lot2 卖量2
 * @property float $ask3 卖价3
 * @property int $ask_lot3 卖量3
 * @property float $ask4 卖价4
 * @property int $ask_lot4 卖量4
 * @property float $ask5 卖价5
 * @property int $ask_lot5 卖量5
 * @property int $volume 成交量
 * @property int $weight 成交（双边）重量
 * @property float $high_limit 涨停板
 * @property float $low_limit 跌停板
 * @property float $up_down 涨跌
 * @property string $up_down_rate 涨跌幅度
 * @property string $turn_over 成交额
 * @property float $average 均价
 * @property string $quote_date 行情时间
 * @property float $last_settle 昨结（现货没有昨结）
 * @property float $settle 结算价（现货没有结算价）
 * @property int $posi 持仓量（现货没有持仓量）
 * @property string $up_rate 涨幅（实际就是涨跌幅度的四舍五入保留两位小数）（延期和远期是涨跌除以昨结、现货是涨跌除以昨收）
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereAsk1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereAsk2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereAsk3($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereAsk4($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereAsk5($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereAskLot1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereAskLot2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereAskLot3($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereAskLot4($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereAskLot5($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereAverage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereBid1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereBid2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereBid3($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereBid4($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereBid5($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereBidLot1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereBidLot2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereBidLot3($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereBidLot4($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereBidLot5($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereClose($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereHigh($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereHighLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereInstId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereLast($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereLastClose($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereLastSettle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereLow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereLowLimit($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereOpen($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo wherePosi($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereQuoteDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereSettle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereTurnOver($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereUpDown($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereUpDownRate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereUpRate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereVolume($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\LastQuo whereWeight($value)
 * @mixin \Eloquent
 */
class LastQuo extends Model
{
    //
    protected $table = 'last_quo';
}

<?php
/**
 * Created by PhpStorm.
 * User: zyc
 * Date: 2017/3/3
 * Time: 14:32
 **/

namespace App\Repository;

use App\Entity\Account;
use App\Entity\GoldAccount;
use App\Entity\UserAuth;
use App\Entity\MoneyRecord;
use App\Entity\DeferMatch;
use GuzzleHttp\Client;

class AccountRepository extends Repository
{
  public function index($filter = null, $isOpen = null, $selectedBranch = null)
  {
    $data = $this->getSearchAbleData(Account::class, [], function ($builder) use ($isOpen, $filter, $selectedBranch) {
      $builder->leftJoin('gold_account', 'gold_account.user_id', '=', 'user.id');
      $builder->leftJoin('brokers', 'brokers.id', '=', 'user.broker_id');
      $builder->select([
        'user.nick_name',
        'gold_account.name',
        'gold_account.cred_num',
        'user.phone',
        'brokers.broker_id',
        'brokers.broker_name',
        'gold_account.gold_num',
        'user.id',
        'user.real_name',
      ]);

      if (!empty($isOpen)) {
        if ($isOpen == 1) {
          $builder->where('gold_account.gold_num', '<>', '');
        } else {
          $builder->where(function ($builder) {
            $builder->where('gold_account.gold_num', '=', '')
              ->orWhereNull('gold_account.gold_num');
          });
        }
      }

      if (!empty($selectedBranch)) {
          $builder->where('brokers.branch_id','=',$selectedBranch);
      }

      if (!empty($filter)) {
        $builder->where(function ($builder) use ($filter) {
          $builder->where('gold_account.name', 'like', "%$filter%")
            ->orWhere('gold_account.cred_num', 'like', "%$filter%")
            ->orWhere('user.nick_name', 'like', "%$filter%")
            ->orWhere('user.phone', 'like', "%$filter%")
            ->orWhere('brokers.broker_id', 'like', "%$filter%");
        });
      }
    });
    return $data;
  }

  public function debits($id)
  {
    $builder = GoldAccount::where('user_id', '=', $id);
    $builder->select('name', 'gold_num', 'cred_num', 'bank_num', 'user_id', 'bank_type');
    $builder->with('bank', 'auth');
    $data['goldAccount'] = $builder->first();
    $data['AuHedgeye'] = DeferMatch::where('user_id', '=', $id)->whereIn('exch_type', [1, 2])->where('inst_id', 1)->sum('match_amount');
    $data['AgHedgeye'] = DeferMatch::where('user_id', '=', $id)->whereIn('exch_type', [1, 2])->where('inst_id', 2)->sum('match_amount');
    $data['mAuHedgeye'] = DeferMatch::where('user_id', '=', $id)->whereIn('exch_type', [1, 2])->where('inst_id', 3)->sum('match_amount');
    $data['rollOut'] = MoneyRecord::where('user_id', '=', $id)->where('access_way', 2)->where('in_account_flag', 1)->sum('exch_bal');
    $data['rollIn'] = MoneyRecord::where('user_id', '=', $id)->where('access_way', 1)->where('in_account_flag', 1)->sum('exch_bal');
    $data['equity'] = $this->_getStaticEquity($data['goldAccount']['gold_num']);
    return $data;
  }

  private function _getStaticEquity($goldNum)
  {
    $url = 'https://www.jsj1314.cn:8444/query/bank  rollQuery';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ['goldNum' => $goldNum]);
    $data = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($data, true);
    if (isset($data['code'])) {
      return '客户账号不存在';
    } else {
      return $data[0]['curr_bal'] + $data[0]['float_surplus'];
    }
  }
}
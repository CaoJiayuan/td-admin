<?php

namespace App\Http\Controllers;

use App\Entity\User;
use Illuminate\Http\Request;
use App\Repository\Repository;
use App\Entity\Broker;
use App\Entity\GoldAccount;
use App\Entity\UserBal;
use App\Repository\AccountRepository;
use App\Entity\MoneyRecord;
use Validator;
use App\Entity\Branch;
use App\Entity\Account;

class AccountController extends Controller
{
  public function index(AccountRepository $repository, Request $request)
  {
    $isOpen = $request->input('isOpen', null);
    $filter = $request->input('filter', null);
    $selectedBranch = $request->input('selectedBranch',null);
    $data = $repository->index($filter, $isOpen,$selectedBranch);
    return response()->json($data);
  }

  public function getBroker($branch_id = 0)
  {
    $builder = Broker::orderBy('id', 'desc');
    $builder = $builder->select('id','broker_name');
    if($branch_id) $builder->where('branch_id','=',$branch_id);
    $data['brokers'] = $builder->get();
    $data['branches'] = Branch::get();
    return response()->json($data);
  }

  public function setBroker(Request $request)
  {
    $messages = [
      'users_id.required' => '请选择客户',
      'broker_id.required' => '请选择客户经理',
    ];
    $rules = [
      'users_id' => 'required',
      'broker_id' => 'required'
    ];
    Validator::make($request->all(), $rules, $messages)->validate();
    $data = $request->all();
    Account::whereIn('id', $data['users_id'])->update(['broker_id' => $data['broker_id']]);
  }

  public function debits($id, AccountRepository $repository)
  {
    $data = $repository->debits($id);
    return response()->json($data);
  }

  public function capital($id, Repository $repository)
  {
    $data = $repository->getSearchAbleData(UserBal::class, ['exch_date'], function ($builder) use ($id) {
      $builder->where('user_id', '=', $id);
    });
    return response()->json($data);
  }

  public function transfers($id, Repository $repository)
  {
    $data = $repository->getSearchAbleData(MoneyRecord::class, ['o_date'], function ($builder) use ($id) {
      $builder->where('user_id', '=', $id);
    });
    return response()->json($data);
  }

  public function getBranches()
  {
    $data = Branch::select('branch_id','branch_name','id')->get();
    return response()->json($data);
  }
}

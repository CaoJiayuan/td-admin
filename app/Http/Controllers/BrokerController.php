<?php

namespace App\Http\Controllers;

use App\Repository\BrokerRepository;
use App\User;
use Illuminate\Http\Request;
use App\Entity\Broker;
use App\Repository\Repository;
use App\Entity\Branch;
use Validator;
use App\Entity\GoldAccount;
use App\Entity\Account;

class BrokerController extends Controller
{
  public function index(Repository $repository,Request $request)
  {
    $selectedBranch = $request->input('selectedBranch',null);
    $data = $repository->getSearchAbleData(Broker::class, ['broker_name', 'broker_id'], function ($builder) use ($selectedBranch) {
      $user = \Auth::user();
      if ($user->hasRole('broker'))
        $builder->where('admin_id', '=', $user['id']);
      $builder->with('accountCount');
      $builder->with('branch');
      if (!empty($selectedBranch))
      {
        $builder->where('branch_id','=',$selectedBranch);
      }
    });
    return response()->json($data);
  }

  public function getBranches()
  {
    $data['branches'] = Branch::where('status', 1)->get();
    $data['operators'] = config('operators');
    return response()->json($data);
  }

  public function postAdd(Request $request, BrokerRepository $broker)
  {
    $rules = [
      'operator_code' => 'required',
      'broker_name' => 'required',
      'branch_id' => 'required',
      'sex' => 'required',
      'cred_num' => 'required|size:18',
      'phone' => 'required|mobile',
      'email' => 'required|email',
    ];
    $messages = [
      'operator_code.required' => '请选择运营商编号',
      'broker_name.required' => '请输入客户经理名字',
      'branch_id.required' => '请选择单位',
      'sex.required' => '请选择性别',
      'cred_num.required' => '请输入身份证号',
      'cred_num.size' => '请输入正确的身份证号',
      'phone.required' => '请输入手机号',
      'email.required' => '请输入邮箱',
      'email.email' => '邮箱格式不正确',
      'phone.mobile' => '手机号格式不正确',
    ];
    Validator::make($request->all(), $rules, $messages)->validate();
    $data = $request->all();
    return response()->json($broker->create($data));
  }

  public function edit($id)
  {
    $data['broker'] = Broker::find($id);
    $data['branches'] = Branch::where('status', 1)->get();
    $data['operators'] = config('operators');
    return response()->json($data);
  }

  public function postEdit(Request $request)
  {
    $rules = [
      'broker_name' => 'required',
      'branch_id' => 'required',
      'operator_code' => 'required',
      'sex' => 'required',
      'cred_num' => 'required|size:18',
      'phone' => 'required|mobile',
      'email' => 'required|email'
    ];
    $messages = [
      'broker_name.required' => '请输入客户经理名字',
      'branch_id.required' => '请选择单位',
      'operator_code.required' => '请选择运营商编号',
      'phone.required' => '请输入手机号',
      'sex.required' => '请选择性别',
      'cred_num.required' => '请输入身份证号',
      'cred_num.size' => '请输入正确的身份证号',
      'phone.mobile' => '手机号格式不正确',
      'email.email' => '邮箱格式不正确',
      'email.required' => '请输入邮箱'
    ];
    Validator::make($request->all(), $rules, $messages)->validate();
    $data = $request->all();
    \DB::transaction(function() use ($data){
      Broker::whereId($data['id'])->update($data);
      $admin = Broker::select('admin_id')->find($data['id']);
      User::whereId($admin['admin_id'])->update(['branch_id'=>$data['branch_id']]);
    });
  }

  public function modifyStatus($id)
  {
    $broker = Broker::find($id);
    $broker->status = $broker['status'] ? 0 : 1;
    if (!$broker['status']) {
      if (Account::where('broker_id','=', $id)->count())
        return response()->json(['code' => 403, 'message' => '请先移除客户经理下的用户']);
    }
    $broker->save();
    return response()->json(['code' => 200]);
  }

  public function delete($id)
  {
    $broker = Broker::find($id);
    if (Account::where('broker_id', '=', $id)->count())
      return response()->json(['code' => 403, 'message' => '请先移除客户经理下的用户']);
    Broker::destroy($id);
    return response()->json(['code' => 200]);
  }
}

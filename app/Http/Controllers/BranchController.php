<?php

namespace App\Http\Controllers;

use Doctrine\Common\Collections\Expr\Value;
use Illuminate\Http\Request;
use App\Repository\Repository;
use App\Entity\Branch;
use Validator;
use App\Entity\Broker;

class BranchController extends Controller
{
  public function index(Repository $repository)
  {
    $data = $repository->getSearchAbleData(Branch::class, ['branch_name', 'branch_id'], function ($builder) {
      $builder->with('parent');
    });
    return response()->json($data);
  }

  public function getParentBranches($id)
  {
    $data = Branch::whereStatus(1)->where('id','<>',$id)->get();
    return response()->json($data);
  }

  //获取第一级节点
  public function getParentselectBranches()
  {
    $data=Branch::withTrashed()->whereStatus(1)->where('parent_id','=',null)->get();
    return response()->json($data);
  }

  //获取孩子节点
  public function getChildBranches($id)
  {
    $data=Branch::withTrashed()->whereStatus(1)->where('parent_id','=',$id)->get();
    return response()->json($data);
  }

  public function postAdd(Request $request)
  {
    $rules = [
      'branch_name' => 'required',
    ];
    $messages = [
      'branch_name.required' => '请输入单位名称'
    ];
    Validator::make($request->all(),$rules,$messages)->validate();
    $data['branch_name'] = $request->input('branch_name');
    $data['parent_id'] = $request->input('parent_id', null);
    if(Branch::where('branch_name','=',$data['branch_name'])->count())
      return response()->json(['message'=>'该单位已存在','code'=>422]);
    if (!empty($data['parent_id'])) {
      $parent = Branch::find($data['parent_id']);
      $data['branch_internal_code'] = $parent['branch_internal_code'] . './' . $parent['id'];
    }
    $data['branch_id'] = md5(microtime());
    $branch = Branch::create($data);
    $branch->branch_id = 'BJG'.$branch['id'];
    $branch->save();
    return response()->json(['message'=>'添加成功','code'=>200]);
  }

  public function edit($id)
  {
    $data = Branch::find($id);
    return response()->json($data);
  }

  public function postEdit(Request $request)
  {
    $rules = [
      'branch_name' => 'required',
    ];
    $messages = [
      'branch_name.required' => '请输入单位名称'
    ];
    Validator::make($request->all(),$rules,$messages)->validate();
    $id = $request->input('id');
    $parent_id = $request->input('parent_id', null);
    if (!empty($parent_id)) {
      $parent = Branch::find($parent_id);
      $data['branch_internal_code'] = $parent['branch_internal_code'] . './' . $parent['id'];
    }
    $data['parent_id'] = $parent_id;
    $data['branch_name'] = $request->input('branch_name');
    if(Branch::where('branch_name','=',$data['branch_name'])->where('id','!=',$id)->count())
      return response()->json(['message'=>'该单位已存在','code'=>422]);
    Branch::whereId($id)->update($data);
    return response()->json(['message'=>'修改成功','code'=>200]);
  }

  public function modifyStatus($id)
  {
    $branch = Branch::find($id);
    $branch->status = $branch['status'] ? 0 : 1;
    if(!$branch['status'])
    {
      $broker = Broker::withTrashed()->where('branch_id','=',$id)->count();
      if($broker)
        return response()->json(['code'=>403,'message'=>'请先移除该单位下的客户经理']);
    }
    $branch->save();
    return response()->json(['code'=>200]);
  }

  public function delete($id)
  {
    $branch = Branch::find($id);
    $broker = Broker::withTrashed()->where('branch_id','=',$id)->count();
    if($broker)
      return response()->json(['code'=>403,'message'=>'请先移除该单位下的客户经理']);
    Branch::destroy($id);
    return response()->json(['code'=>200]);
  }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\Repository;
use App\Entity\Join;
use Validator;

class RecruitsController extends Controller
{
  public function index(Repository $repository)
  {
    $data = $repository->getSearchAbleData(Join::class, ['id', 'position', 'num']);
    return response()->json($data);
  }

  public function add(Request $request)
  {
    $messages = [
      'position.required' => '请输入职位',
      'num.required' => '请输入招聘人数',
      'request.required' => '请输入职位要求',
      'position.required' => '请输入职位描述',
    ];
    $rules = [
      'position' => 'required',
      'num' => 'required',
      'request' => 'required',
      'describe' => 'required',
    ];
    Validator::make($request->all(),$rules,$messages)->validate();
    $data = $request->all();
    Join::create($data);
  }

  public function modifyStatus($id)
  {
    $join = Join::find($id);
    $join->status = $join['status'] ? 0 : 1;
    $join->save();
  }

  public function edit($id)
  {
    $data = Join::find($id);
    return response()->json($data);
  }

  public function postEdit(Request $request)
  {
    $messages = [
      'position.required' => '请输入职位',
      'num.required' => '请输入招聘人数',
      'request.required' => '请输入职位要求',
      'position.required' => '请输入职位描述',
      'id.required' => '参数错误',
    ];
    $rules = [
      'position' => 'required',
      'num' => 'required',
      'request' => 'required',
      'describe' => 'required',
      'id' => 'required'
    ];
    Validator::make($request->all(),$rules,$messages)->validate();
    $data = $request->all();
    Join::whereId($data['id'])->update($data);
  }

  public function delete($id)
  {
    Join::destroy($id);
  }
}

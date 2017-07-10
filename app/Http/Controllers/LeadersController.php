<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\Repository;
use App\Entity\Leader;
use Validator;

class LeadersController extends Controller
{
  public function index(Repository $repository)
  {
    $data = $repository->getSearchAbleData(Leader::class, ['name', 'status', 'position', 'img']);
    return response()->json($data);
  }

  public function add(Request $request)
  {
    $messages = [
      'name.required' => '请输入领导名字',
      'position.required' => '请输入领导职位',
      'img.required' => '请上传领导头像',
    ];
    $rules = [
      'name' => 'required',
      'position' => 'required',
      'img' => 'required',
    ];
    Validator::make($request->all(), $rules, $messages)->validate();
    $data = $request->all();
    Leader::create($data);
  }

  public function modifyStatus($id)
  {
    $leader = Leader::find($id);
    $leader->status = $leader['status'] ? 0 : 1;
    $leader->save();
  }

  public function edit($id)
  {
    $data = Leader::find($id);
    return response()->json($data);
  }

  public function postEdit(Request $request)
  {
    $messages = [
      'name.required' => '请输入领导名字',
      'position.required' => '请输入领导职位',
      'img.required' => '请上传领导头像',
      'id.required' => '请求参数错误',
    ];
    $rules = [
      'name' => 'required',
      'position' => 'required',
      'img' => 'required',
      'id' => 'required',
    ];
    Validator::make($request->all(), $rules, $messages)->validate();
    $data = $request->all();
    Leader::whereId($data['id'])->update($data);
  }

  public function delete($id)
  {
    Leader::destroy($id);
  }
}

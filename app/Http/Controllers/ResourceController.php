<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\Repository;
use App\Entity\Resource;
use App\Traits\Uploads;
use Validator;
use App\Entity\Ad;
use App\Entity\Notifiation;

class ResourceController extends Controller
{
  use Uploads;

  public function index(Repository $repository)
  {
    $data = $repository->getSearchAbleData(Resource::class, ['name', 'status', 'id', 'content']);
    return response()->json($data);
  }

  public function add(Request $request)
  {
    $messages = [
      'name.required' => '请输入素材标题',
      'name.content' => '请输入素材内容',
    ];
    $rules = [
      'name' => 'required',
      'content' => 'required'
    ];
    Validator::make($request->all(),$rules,$messages)->validate();
    $content = $request->input('content');
    $content = $this->decodeBase64Image($content);
    $resource['content'] = $content;
    $resource['name'] = $request->input('name');
    Resource::create($resource);
  }

  public function modifyStatus($id)
  {
    if(Ad::whereType(0)->where('url','=',$id)->count()||Notifiation::whereType(3)->where('url','=',$id)->count())
    {
      $data['code'] = 422;
      $data['message'] = '该素材正在使用';
    }else{
      $resource = Resource::whereId($id)->first();
      $resource->status = $resource['status'] ? 0 : 1;
      $resource->save();
      $data['code'] = 200;
    }
    return response()->json($data);
  }

  public function edit($id)
  {
    $resource = Resource::whereId($id)->select('name', 'id', 'content')->first();
    return response()->json($resource);
  }

  public function postEdit(Request $request)
  {
    $messages = [
      'name.required' => '请输入素材标题',
      'name.content' => '请输入素材内容',
    ];
    $rules = [
      'name' => 'required',
      'content' => 'required'
    ];
    Validator::make($request->all(),$rules,$messages)->validate();
    $content = $request->input('content');
    $content = $this->decodeBase64Image($content);
    $resource['content'] = $content;
    $resource['name'] = $request->input('name');
    $id = $request->input('id');
    Resource::whereId($id)->update($resource);
  }

  public function delete($id)
  {
    if(Ad::whereType(0)->where('url','=',$id)->count()||Notifiation::whereType(3)->where('url','=',$id)->count())
    {
      $data['code'] = 422;
      $data['message'] = '该素材正在使用';
    }else{
      Resource::destroy($id);
      $data['code'] = 200;
    }
    return response()->json($data);
  }
}

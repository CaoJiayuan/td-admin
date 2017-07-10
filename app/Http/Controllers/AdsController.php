<?php

namespace App\Http\Controllers;

use App\Entity\Ad;
use App\Entity\Resource;
use App\Repository\Repository;
use Validator;
use App\Entity\Scoop;

use Illuminate\Http\Request;

class AdsController extends Controller
{
  public function index(Repository $repository)
  {
    $data = $repository->getSearchAbleData(Ad::class,['id','title']);
    $data['type'] = config('adsType.adsType');
    $data['positions'] = config('adsPositions.adsPositions');
    return response()->json($data);
  }

  public function add()
  {
    $data['positions'] = config('adsPositions.adsPositions');
    $data['type'] = config('adsType.adsType');
    return response()->json($data);
  }

  public function postAds(Request $request)
  {
    $messages = [
      'title.required' => '请输入广告标题',
      'img.required' => '请选择图片',
      'ad_position_id.required' => '请选择广告位置',
      'type.required' => '请选择广告内容',
    ];
    $rules = [
      'title' => 'required',
      'img' => 'required',
      'ad_position_id' => 'required',
      'type' => 'required'
    ];
    Validator::make($request->all(),$rules,$messages)->validate();
    $ads = $request->all();
    Ad::create($ads);
  }

  public function modifyStatus($id)
  {
    $ads = Ad::whereId($id)->first();
    $ads->status = $ads['status'] ? 0 : 1;
    $ads->save();
  }

  public function edit($id){
    $data['position'] = config('adsPositions.adsPositions');
    $data['ads'] = Ad::whereId($id)->first();
    $data['type'] = config('adsType.adsType');
    return response()->json($data);
  }

  public function postEdit(Request $request){
    $messages = [
      'title.required' => '请输入广告标题',
      'img.required' => '请选择图片',
      'ad_position_id.required' => '请选择广告位置',
      'type.required' => '请选择广告类型',
    ];
    $rules = [
      'title' => 'required',
      'img' => 'required',
      'ad_position_id' => 'required',
      'type' => 'required'
    ];
    Validator::make($request->all(),$rules,$messages)->validate();
    $ads = $request->all();
    Ad::whereId($ads['id'])->update($ads);
  }

  public function delete($id)
  {
    Ad::destroy($id);
  }
}

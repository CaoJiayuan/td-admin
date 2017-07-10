<?php

namespace App\Http\Controllers;

use App\Entity\Notifiation;
use App\Entity\Resource;
use App\Repository\NotificationRepository;
use App\Repository\Repository;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Jobs\PushMessage;
use PushSDK;

class NoticeController extends Controller
{
  public function index(Repository $repository)
  {
    $data = $repository->getSearchAbleData(Notifiation::class, ['id', 'title', 'publish_at']);
    $data['type'] = config('noticeType.noticeType');
    return response()->json($data);
  }

  public function add()
  {
    $type = config('noticeType.noticeType');
    return response()->json($type);
  }

  public function postAdd(Request $request)
  {
    $messages = [
      'title.required' => '请输入公告标题',
      'content.required' => '请输入公告内容',
      'type.required' => '请选择跳转位置',
    ];
    $rules = [
      'title' => 'required',
      'content' => 'required',
      'type' => 'required'
    ];
    Validator::make($request->all(), $rules, $messages)->validate();
    $data = $request->all();
    $data['publish_at'] = Carbon::now();
    if (in_array($data['type'], [0, 1, 2])) {
      $type = config('noticeType.noticeType');
      foreach ($type as $v) {
        if ($request->input('type') == $v['code']) {
          $data['url'] = $v['name'];
        }
      }
    }
    Notifiation::create($data);
  }

  public function edit($id)
  {
    $data['notice'] = Notifiation::findOrFail($id);
    $data['type'] = config('noticeType.noticeType');
    return response()->json($data);
  }

  public function postEdit(Request $request)
  {
    $messages = [
      'title.required' => '请输入公告标题',
      'content.required' => '请输入公告内容',
      'type.required' => '请选择跳转位置',
      'id.required' => '请求参数错误'
    ];
    $rules = [
      'title' => 'required',
      'content' => 'required',
      'type' => 'required',
      'id' => 'required'
    ];
    Validator::make($request->all(), $rules, $messages)->validate();
    $data = $request->all();
    $data['publish_at'] = Carbon::now();
    if (in_array($data['type'], [0, 1, 2])) {
      $type = config('noticeType.noticeType');
      foreach ($type as $v) {
        if ($data['type'] == $v['code']) {
          $data['url'] = $v['name'];
        }
      }
    }
    Notifiation::whereId($data['id'])->update($data);
  }

  public function publish($id)
  {
    $notice = Notifiation::select('id')->find($id);
    dispatch(new PushMessage($notice));
    if($this->afterPush($id))
    {
      $data['code'] = 200;
    }else{
      $data['code'] = 500;
    }
    return $data;
  }

  public function delete($id)
  {
    Notifiation::destroy($id);
  }

  protected function afterPush($id)
  {
    $data = Notifiation::select('status')->find($id);
    if($data['status']==2) return true;
    return false;
  }
}

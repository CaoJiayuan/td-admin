<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\Repository;
use App\Entity\Contact;
use Validator;

class ContactsController extends Controller
{
  public function index(Repository $repository)
  {
    $data = $repository->getSearchAbleData(Contact::class, ['id', 'key', 'value']);
    return response()->json($data);
  }

  public function add(Request $request)
  {
    $messages = [
      'key.required' => '请输入联系方式名称',
      'value.required' => '请输入联系方式'
    ];
    $rules = [
      'key' => 'required',
      'value' => 'required',
    ];
    Validator::make($request->all(),$rules,$messages)->validate();
    $data = $request->all();
    Contact::create($data);
  }

  public function modifyStatus($id)
  {
    $contact = Contact::find($id);
    $contact->status = $contact['status'] ? 0 : 1;
    $contact->save();
  }

  public function edit($id)
  {
    $data = Contact::find($id);
    return response()->json($data);
  }

  public function postEdit(Request $request)
  {
    $messages = [
      'key.required' => '请输入联系方式名称',
      'value.required' => '请输入联系方式',
      'id.required' => '请求参数错误'
    ];
    $rules = [
      'key' => 'required',
      'value' => 'required',
      'id' => 'required'
    ];
    Validator::make($request->all(),$rules,$messages)->valid();
    $data = $request->all();
    Contact::whereId($data['id'])->update($data);
  }

  public function delete($id)
  {
    Contact::destroy($id);
  }
}

<?php

namespace App\Http\Controllers;

use App\Repository\ServiceRepository;
use Validator;
use Illuminate\Http\Request;
class ServiceController extends Controller
{
    public function services(ServiceRepository $repository)
    {
        return $repository->getServices();
    }

    public function branches(ServiceRepository $repository)
    {
        return $repository->getBranches();
    }

    public function brancheUpdate(ServiceRepository $repository)
    {
        return $repository->updateBranch();
    }

    public function serviceAdd(ServiceRepository $repository, Request $request)
    {
        $data = [
            'id' => 'required',
            'name' => 'required',
            'mobile' => 'required|mobile',
            'email' => 'required|email',
            'remarks' => 'required',
            'address' => 'required',
            'password'
        ];
        $message = [
            'id.required' => '请选择单位编号',
            'name.required' => '请输入客服姓名',
            'mobile.required' => '请输入手机号码',
            'email.required' => '请输入客服邮箱',
            'remarks.required' => '请输入备注',
            'address.required' => '请输入联系地址'
        ];
        Validator::make($request->all(), $data, $message)->validate();
        $data = $request->all();
        return $repository->addService($data);
    }

    public function getService(ServiceRepository $repository, $id)
    {//更新获取数据
        return $repository->getServiceOne($id);
    }

    public function postEdit(ServiceRepository $repository, Request $request, $id)
    {
        $data = [
            'branch_id',
            'name' => 'required',
            'mobile' => 'required|mobile',
            'email' => 'required|email',
            'remarks' => 'required',
            'address' => 'required',
        ];
        $message = [
            'branch_id' => '请选择单位编号',
            'name.required' => '请输入客服姓名',
            'mobile.required' => '请输入手机号码',
            'email.required' => '请输入客服邮箱',
            'remarks.required' => '请输入备注',
            'address.required' => '请输入联系地址',
        ];
        Validator::make($request->all(), $data, $message)->validate();
        $data = $request->all();
        return $repository->editService($data, $id);
    }

    public function delService(ServiceRepository $repository, $id)
    {
        return $repository->serviceDel($id);
    }

    public function branchShow(ServiceRepository $repository, $id)
    {
        return $repository->showBranch($id);
    }
}

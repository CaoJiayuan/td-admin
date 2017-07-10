<?php
/**
 * Created by PhpStorm.
 * User: zyc
 * Date: 2017/3/22
 * Time: 17:18
 **/
namespace App\Repository;

use App\Entity\Branch;
use App\Entity\Role;
use App\Jobs\LoginService;
use App\User;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ServiceRepository extends Repository
{
    public function getServices()
    {
        return $this->getSearchAbleData(User::class, [
            'id', 'name', 'branch_id', 'mobile', 'email', 'address', 'remarks'
        ], function ($builder) {
            $name = config("entrust.service.name");
            $service = Role::where('name', $name)->first();
            $builder->join('role_admin', 'role_admin.admin_id', '=', 'admins.id')->where('role_id', $service['id']);
            $builder->join('branchs', 'branchs.id', '=', 'admins.branch_id')->where('deleted_at', null);
            $builder->select([
                'admins.*',
                'branchs.branch_id',
            ]);
            $builder->groupBy('admins.id');
            $builder->orderBy('id', 'desc');
        });
    }

    public function getBranches()
    {//获取单位编号 status 1 启用状态  /deleted_at 是否删除
        $data = DB::table('branchs')->where('status', 1)->where('deleted_at', null)->select(['id', 'branch_id', 'status', 'deleted_at'])->get()->toArray();
        $add[] = ['id'=>0, 'branch_id'=>'查询所有信息'];
        $data = array_merge($add, $data);
        return response()->json($data);
    }

    public function updateBranch()
    {
        $data = Branch::where('status', 1)->where('deleted_at', null)->select(['id', 'branch_id', 'status', 'deleted_at'])->get();
        return response()->json($data);
    }

    public function addService($data)
    {
        $msg = \DB::transaction(function () use ($data) {
            if (User::where('email', '=', $data['email'])->count()) {
                throw new UnprocessableEntityHttpException('邮箱已被占用');
            } else if (User::where('mobile', '=', $data['mobile'])->count()) {
                throw new UnprocessableEntityHttpException('手机号已被占用');
            } else {//$data['id']是branchs表中单位编号对应的ID
               $pass = 123456;
               $res = User::create([
                  'name' => $data['name'],
                  'mobile' => $data['mobile'],
                  'email' => $data['email'],
                  'remarks' => $data['remarks'],
                  'address' => $data['address'],
                  'branch_id' => $data['id']['id'],
                  'password' => bcrypt($pass)
               ]);
               $name = config('entrust.service.name');
               $service = Role::where('name', $name)->first();//取出客服service->ID
               DB::table('role_admin')->insert(//将admin_id和role_id插入到role_admin
                  ['admin_id' => $res->id, 'role_id' => $service->id]
               );
            }
        });
        dispatch(new LoginService($data));
        return $msg;
    }

    public function getServiceOne($id)
    {
        $data = User::with('service')->find($id);
        return $data->toArray();
    }

    public function editService($data, $id)
    {
        \DB::transaction(function () use ($data, $id) {
          if (User::where('email', '=', $data['email'])->where('id', '<>', $id)->count()) {
             throw new UnprocessableEntityHttpException('邮箱已被占用');
          } else if (User::where('mobile', '=', $data['mobile'])->where('id', '<>', $id)->count()) {
             throw new UnprocessableEntityHttpException('手机号已被占用');
          } else {
             $res = $data['service']['id'];
             if ($res == "") {
                User::where('id', $id)->update([
                   'name' => $data['name'],
                   'mobile' => $data['mobile'],
                   'email' => $data['email'],
                   'remarks' => $data['remarks'],
                   'address' => $data['address']
                ]);
             } else {
                User::where('id', $id)->update([
                   'name' => $data['name'],
                   'mobile' => $data['mobile'],
                   'email' => $data['email'],
                   'remarks' => $data['remarks'],
                   'address' => $data['address'],
                   'branch_id' => $res
                ]);
             }
          }
       });
      dispatch(new LoginService($data));
    }

    public function serviceDel($id)
    {
        if (User::where('id', $id)->delete()) {
            DB::table('role_admin')->where('admin_id', $id)->delete();
            DB::table('im_users')->where('service_id', $id)->update(['service_id' => null]);
            DB::table('im_users')->where('user_id', $id)->delete();
        } else {
           die;
        }
    }

    public function showBranch($id)
    {
        return $this->getSearchAbleData(User::class, [
            'id', 'name', 'branch_id', 'mobile', 'email', 'address', 'remarks'
        ], function ($builder) use ($id){
           $name = config('entrust.service.name');
            $service = Role::where('name', $name)->first();
            $builder->join('role_admin', 'role_admin.admin_id', '=', 'admins.id')->where('role_id', $service['id']);
            $builder->join('branchs', 'branchs.id', '=', 'admins.branch_id')->where('admins.branch_id', '=', $id);
            $builder->select([
                'admins.*',
                'branchs.branch_id'
            ]);
            $builder->groupBy('admins.id');
            $builder->orderBy('id', 'desc');
        });
    }
}
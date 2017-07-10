<?php
/**
 * Created by PhpStorm.
 * User: zyc
 * Date: 2017/3/3
 * Time: 14:32
 **/

namespace App\Repository;

use App\Entity\Broker;
use App\User;
use App\Jobs\LoginService;

class BrokerRepository extends Repository
{
  public function create($data)
  {
    $msg = \DB::transaction(function() use ($data){
      if(User::where('email','=',$data['email'])->count())
        return ['code'=>403,'message'=>'该邮箱已被占用'];
      if(User::where('mobile','=',$data['phone'])->count())
        return ['code'=>403,'message'=>'该手机号已被占用'];
      $userData['email'] = $data['email'];
      $userData['mobile'] = $data['phone'];
      $userData['password'] = bcrypt('123456');
      $userData['name'] = $data['broker_name'];
      $userData['branch_id'] = $data['branch_id'];
      $user = User::create($userData);
      \DB::table('role_admin')->insert(['admin_id'=>$user['id'],'role_id'=>2]);
      $data['original_broker_id'] = 0;
      $data['admin_id'] = $user['id'];
      $broker = Broker::create($data);
      $broker->broker_id = $data['operator_code'].'JSJ'.$broker['id'];
      $broker->save();
      return ['code'=>200];
    });
    dispatch(new LoginService($data));
    return $msg;
  }
}
<?php
use App\Entity\Permission;
use App\Entity\Role;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * Created by Cao Jiayuan.
 * Date: 17-3-1
 * Time: 上午11:21
 */
class PermissionSeeder extends Seeder
{

  public function run()
  {
    DB::table('permissions')->truncate();
    DB::table('permission_role')->truncate();
    Model::unguard();
    $su = config('entrust.entrust', [
      'name'         => 'super_admin',
      'display_name' => '超级管理员',
      'description'  => 'su'
    ]);
    $su = Role::firstOrCreate($su, $su);
    $bk = config('entrust.broker', [
      'name'         => 'broker',
      'display_name' => '客户经理',
      'description'  => 'broker'
    ]);
    Role::firstOrCreate($bk, $bk);
    $sv = config('entrust.service', [
      'name'         => 'service',
      'display_name' => '客服',
      'description'  => 'service'
    ]);
    Role::firstOrCreate($sv, $sv);
    /** @var User $user */
    $user = User::firstOrCreate([
      'email'    => 'admin@honc.tech'
    ],[
      'name'     => 'SuperAdmin',
      'email'    => 'admin@honc.tech',
      'password' => bcrypt(123456),
    ]);
    if (!$user->hasRole($su->name)) {
      $user->attachRole($su);
    }
    $permissions = config('permissions', []);
    $this->seedPermissions($permissions);
    Model::reguard();
  }

  public function seedPermissions($permissions, $parentId = null)
  {
    $pId = 0;
    $parentId && $pId = $parentId;
    foreach ($permissions as $permission) {
      $attributes = array_only($permission, ['path', 'name', 'display_name', 'icon', 'description','type']);
      $attributes['parent_id'] = $pId;
      $p = Permission::create($attributes);
      $this->seedPermissions(array_get($permission, 'node', []), $p->id);
    }
  }
}
<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-3-1
 * Time: 下午2:19
 */
namespace App\Http\Controllers;

use App\Repository\PermissionRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class PermissionController extends Controller
{
  public function roles(PermissionRepository $repository, Request $request)
  {
    return $repository->getRoles($request->get('api'));
  }
  public function postRole(PermissionRepository $repository)
  {
    $data = $this->getValidatedData([
      'name'         => 'required|max:20',
      'permissions',
      'id',
    ]);
    $data['display_name'] = $data['name'];

    return $repository->createOrUpdateRole($data);
  }
  public function deleteRole(PermissionRepository $repository, $id)
  {
    return $repository->deleteRole($id);
  }
  public function tree(PermissionRepository $repository)
  {
    return $repository->tree();
  }
  public function role(PermissionRepository $repository, $id)
  {
    return $repository->role($id);
  }
  public function admins(PermissionRepository $repository)
  {
    return $repository->admins();
  }
  public function postAdmin(PermissionRepository $repository)
  {
    $data = $this->getValidatedData([
      'name'   => 'required',
      'email'  => 'required|email',
      'mobile' => 'mobile',
      'roles',
      'id'
    ]);
    return $repository->createOrUpdateAdmin($data);
  }
  public function getAdmin(PermissionRepository $repository, $id)
  {
    return $repository->admin($id);
  }
  public function deleteAdmin(PermissionRepository $repository, $id)
  {
    return $repository->deleteAdmin($id);
  }
  public function permissions(PermissionRepository $repository)
  {
    return $repository->permissions();
  }
  public function editAdmin(PermissionRepository $repository)
  {
    $data = $this->getValidatedData([
      'name'   => 'required',
      'email'  => 'required|email',
      'mobile' => 'mobile',
    ]);
    $admin = \Auth::user()->toArray();
    $admin = array_merge($admin, $data);
    return $repository->createOrUpdateAdmin($admin);
  }
  public function setPassword(PermissionRepository $repository)
  {
    $data = $this->getValidatedData([
      'old_pass'   => 'required',
      'password'   => 'required|confirmed|min:6',
    ]);
    $user = \Auth::user();
    if (!\Hash::check($data['old_pass'], $user->getAuthPassword())) {
      throw new UnprocessableEntityHttpException('原密码不正确');
    }

    $admin = $user->toArray();
    $admin = array_merge($admin, $data);
    return $repository->createOrUpdateAdmin($admin);
  }
  public function navigation(PermissionRepository $repository)
  {
    return $repository->navigation();
  }
}
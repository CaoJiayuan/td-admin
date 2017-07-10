<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-4-14
 * Time: 下午5:32
 */

namespace App\Http\Controllers;


use App\Entity\Version;
use App\Repository\VersionRepository;

class VersionController extends Controller
{

  public function versions(VersionRepository $repository)
  {
    return $repository->getVersions();
  }

  public function getTypes()
  {

    return config('versionType');
  }

  public function postVersion(VersionRepository $repository)
  {
    $data = $this->getValidatedData([
      'version' => 'required',
      'content' => 'required',
      'type'    => 'required',
      'build'   => 'required|regex:/^\d+$/',
      'id'
    ]);

    $repository->updateOrCreateVersion($data);

    return $this->respondSuccess();
  }

  public function getVersion($id)
  {
    $ver = Version::findOrFail($id)->toArray();
    return $ver;
  }

  public function delVersion($id)
  {
    Version::destroy($id);

    return $this->respondSuccess();
  }
}
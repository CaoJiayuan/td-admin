<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-4-14
 * Time: 下午5:32
 */

namespace App\Repository;


use App\Entity\Version;
use Symfony\Component\HttpKernel\Exception\HttpException;

class VersionRepository extends Repository
{
  public function getVersions()
  {
    return $this->getSearchAbleData(Version::class, [
      'content', 'version'
    ], function ($builder) {

    });
  }

  public function updateOrCreateVersion($data)
  {
    $data['type'] = array_get($data, 'type.type');
    $id = $data['id'] ?: 0;
    if (Version::where('id', '!=', $id)->where('version', $data['version'])->exists()) {
      throw new HttpException(422, '版本号不能重复');
    }

    if (Version::where('id', '!=', $id)->where('build', $data['build'])->exists()) {
      throw new HttpException(422, 'Build code不能重复');
    }
    return Version::updateOrCreate([
      'id' => $data['id']
    ], $data);
  }
}
<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-3-1
 * Time: 下午2:20
 */

namespace App\Repository;

use App\Entity\SgeCatalog;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class SgeRepository extends Repository
{

  public function getSge()
  {
    return $this->getSearchAbleData(SgeCatalog::class, [
      'name', 'status'
    ], function ($builder) {
      $builder->where('status', '<>', 0)->select([
          'SgeCatalogs.*'
      ]);
      $builder->groupBy('SgeCatalogs.id');
    });
  }

  public function createSgeCate($data)
  {
      if (SgeCatalog::where('name', $data['name'])->first()) {
          throw new UnprocessableEntityHttpException('目录名称已存在,请勿重复添加');
      } else if (empty($data['name'])) {
          throw new UnprocessableEntityHttpException('目录名称不能为空');
      }
      SgeCatalog::create([
          'name' => $data['name']
      ]);
  }

  public function updateSgeCate($id,$data)
  {
      if (SgeCatalog::where('name', $data['name'])->find($id) || SgeCatalog::where('name', $data['name'])->first()) {
          throw new UnprocessableEntityHttpException('如需编辑,目录名请勿重复');
      }
      SgeCatalog::where('id', $id)->update([
        'name' => $data['name']
      ]);
  }

  public function deleteSgeCate($id)
  {
      SgeCatalog::where('id', $id)->delete();
  }

}
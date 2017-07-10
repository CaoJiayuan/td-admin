<?php
/**
 * Created by PhpStorm.
 * User: zyc
 * Date: 2017/3/2
 * Time: 22:15
 **/

namespace App\Repository;

use App\Entity\Complaint;
use App\Entity\NewsComments;
use App\Entity\Product;
use App\Entity\ScoopComments;
use App\Traits\Uploads;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ProductRepository extends Repository
{
  use Uploads;

  public function getProducts()
  {
    return $this->getSearchAbleData(Product::class, [
      'name', 'code', 'created_at'
    ], function ($builder) {
      $builder->select('products.*');
    });
  }

  public function addProduct($data)
  {
    if (Product::where('name', $data['name'])->first()) {
      return response()->json(['code' => 422, 'errors' => [], 'message' => '产品名称已存在,请勿重复添加'], 422);
    } else if (!isset($data['name'])) {
      return response()->json(['code' => 412, 'errors' => [], 'message' => '产品名称不能为空'], 412);
    } else if (!isset($data['code'])) {
      return response()->json(['code' => 422, 'errors' => [], 'message' => '产品代码不能为空'], 422);
    } else if (empty($data['content'])) {
      return response()->json(['code' => 422, 'errors' => [], 'message' => '品种概述不能为空'], 422);
    }
    Product::create([
      'name'    => $data['name'],
      'code'    => $data['code'],
      'content' => $this->decodeBase64Image($data['content'])
    ]);
  }

  public function editProduct($data, $id)
  {
    if (Product::where('name', $data['name'])->where('id', '<>', $id)->first()) {
      throw new UnprocessableEntityHttpException('注意!产品名称已存在!!!');
    } else if (!isset($data['name']) || !isset($data['code']) || !isset($data['content'])) {
      throw new UnprocessableEntityHttpException('任意一项都不能为空,请填写完整');
    } else {
      Product::where('id', $id)->update([
        'name'    => $data['name'],
        'code'    => $data['code'],
        'content' => $this->decodeBase64Image($data['content'])
      ]);
    }
  }


  public function delProduct($id)
  {
    Product::where('id', $id)->delete();
  }

  public function complaints()
  {
    return $this->getSearchAbleData(Complaint::class, [
      'type', 'id', 'user_id', 'comment_id' . 'content'
    ], function ($builder) {
      $builder->leftJoin('user', 'user.id', '=', 'complaints.user_id');
      $builder->select([
        'complaints.*',
        'user.nick_name',
      ]);
      $builder->groupBy('complaints.id');
    }, function ($items) {
      $result = [];
      foreach ($items as $item) {
        $item->comment = $item->type ? ScoopComments::find($item->comment_id) : NewsComments::find($item->comment_id) ;
        $item->comment_status = $item->comment ? $item->comment->status : 0;
        $result[] = $item;
      }
      return collect($result);
    });
  }

  public function comments($data)
  {
    if ($data['type'] == 0) {
      $comments = NewsComments::where('id', $data['comment_id'])->first();
      return $comments;
    } else if ($data['type'] == 1) {
      $comments = ScoopComments::where('id', $data['comment_id'])->first();
      return $comments;
    }
  }
}
<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-3-1
 * Time: 下午2:20
 */

namespace App\Repository;

use App\Entity\Scoop;
use App\Entity\ScoopCategories;
use App\Entity\ScoopComments;
use App\Traits\Uploads;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ScoopRepository extends Repository
{
  use Uploads;

  public function getScoops()
  {
    return $this->getSearchAbleData(Scoop::class, [
      'title', 'thumbnail', 'published_at'
    ], function ($builder) {

      $pre = \DB::getTablePrefix();
      /** @var Builder $builder */
      $builder->leftJoin('comments', 'news_id','=','news.id');
      $builder->leftJoin('news_categories', 'news_categories.id','=','news.news_category_id');
      $builder->select([
        'news.*',
        'news_categories.name',
        \DB::raw("count({$pre}comments.id) AS count_comments")
      ]);
      $builder->groupBy('news.id');
    });
  }


  public function getScoopsCategories()
  {
    return $this->getSearchAbleData(ScoopCategories::class, [
      'id', 'name'
    ], function ($builder) {
      /** @var Builder $builder */
      $builder->select([
        'news_categories.*'
      ]);
      $builder->groupBy('news_categories.id');
    });
  }

  public function getScoopComments($id)
  {
    return $this->getSearchAbleData(ScoopComments::class, [
      'id', 'news_id', 'content'
    ], function ($builder) use ($id) {
      /** @var Builder $builder */

      $builder->join('user','user.id','=','comments.user_id');
      $builder->where('news_id',$id);
      $builder->select([
        'comments.*',
        'user.nick_name'
      ]);

      $builder->orderBy('created_at','desc');
    });
  }

  public function addScoopCate($data)
  {
    if(ScoopCategories::where('name',$data['name'])->first()){
      return response()->json(['code' => 422,'errors' => [], 'message' => '类型已存在,请勿重复添加'], 422);
    }else{
      ScoopCategories::create([
        'name' => $data['name']
      ]);
    }

  }

  public function editScoopCate($data,$id)
  {
    if(ScoopCategories::where('name',$data['name'])->first()){
      return response()->json(['code' => 422,'errors' => [], 'message' => '类型已存在,请勿重复添加'], 422);
    }else {
      ScoopCategories::where('id', $id)->update([
        'name' => $data['name']
      ]);
    }
  }

  public function delScoopCate($id)
  {
    $scoop = Scoop::where('news_category_id',$id)->first();
    if ($scoop == ""){
      ScoopCategories::where('id',$id)->delete();
    }else{
      throw new UnprocessableEntityHttpException('请先将该类型新闻全部删除');
    }

  }

  public function delScoop($id)
  {
    Scoop::where('id',$id)->delete();
  }

  public function getCategories()
  {
    $data = ScoopCategories::get();
    return $data;
  }

  public function addScoop($data)
  {
   if ($data['published_at'] ==""){
     Scoop::create([
       'from' => $data['from'],
       'summary' => $data['summary'],
       'thumbnail' => $data['thumbnail'],
       'content' =>$this->decodeBase64Image($data['content']),
       'title' =>$data['title'],
       'news_category_id' =>$data['category']['id'],
       'published_at' => Carbon::now()
     ]);
   }else{
     Scoop::create([
       'from' => $data['from'],
       'summary' => $data['summary'],
       'thumbnail' => $data['thumbnail'],
       'content' =>$this->decodeBase64Image($data['content']),
       'title' =>$data['title'],
       'news_category_id' =>$data['category']['id'],
       'published_at' => $data['published_at']
     ]);
   }

  }

  public function getScoop($id)
  {
    $data = Scoop::with('category')->where('id',$id)->first();
    return $data;
  }

  public function updateScoop($id,$data)
  {
    if ($data['published_at'] =="") {
      Scoop::where('id', $id)->update([
        'from' => $data['from'],
        'summary' => $data['summary'],
        'thumbnail' => $data['thumbnail'],
        'content' => $this->decodeBase64Image($data['content']),
        'title' => $data['title'],
        'news_category_id' => $data['category']['id'],
        'published_at' => Carbon::now()
      ]);
    }else{
      Scoop::where('id', $id)->update([
        'from' => $data['from'],
        'summary' => $data['summary'],
        'thumbnail' => $data['thumbnail'],
        'content' => $this->decodeBase64Image($data['content']),
        'title' => $data['title'],
        'news_category_id' => $data['category']['id'],
        'published_at' => $data['published_at']
      ]);
    }
  }

  public function getScoopCate($id)
  {
    $scoop = Scoop::where('id',$id)->first();
    $data = ScoopCategories::where('id',$scoop['news_category_id'])->first();
    return $data;
  }

  public function changeStatus($id)
  {
    $scoop = ScoopComments::where('id',$id)->first();
    $scoop->status = $scoop['status']? 0 : 1;
    $scoop->save();
  }
}


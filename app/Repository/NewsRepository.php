<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-3-1
 * Time: 下午2:20
 */

namespace App\Repository;

use App\Entity\Comment;
use App\Entity\News;
use App\Entity\NewsComments;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class NewsRepository extends Repository
{

  public function getNews()
  {
    \Request::offsetSet('order','CMD_NEWS_MAIN.pub_time|desc');
    return $this->getSearchAbleData(News::class, [
      'news_id', 'news_author', 'pub_time', 'title_main', 'news_sum'
    ]);
  }

  public function getNewsComments($id)
  {
     return $this->getSearchAbleData(NewsComments::class,[
       'news_id', 'content'
     ],function($builder) use ($id){
       $builder->where('news_id',$id);
       $builder->with('user');
       $builder->select([
         'comments.*',
       ]);
       $builder->groupBy('comments.id');
       $builder->orderBy('created_at','desc');
     });
  }

  public function changeStatus($id)
  {
    $news = NewsComments::where('id',$id)->first();
    $news->status = $news['status']? 0 : 1;
    $news->save();
  }
}
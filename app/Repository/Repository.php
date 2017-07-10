<?php
/**
 * Created by Cao Jiayuan.
 * Date: 17-3-1
 * Time: 下午2:20
 */

namespace App\Repository;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class Repository
{
  public function getSearchAbleData($model, array $search = [], \Closure $closure = null, \Closure $trans = null)
  {
    $data = \Request::only([
      'filter', 'order', 'page_size'
    ]);

    list($filter, $order, $pageSize) = array_values($data);
    if (!is_object($model)) {
      $model = app($model);
    }
    if (!$model instanceof Model) {
      throw new \UnexpectedValueException(__METHOD__ . ' expects parameter 1 to be an object of ' . Model::class . ',' . get_class($model) . ' given');
    }
    $orderArr = explode('|', $order, 2);

    $table = $model->getTable();
    $key = $model->getKeyName();
    list($o, $d) = [array_get($orderArr, 0) ?: $table . '.'. $key, array_get($orderArr, 1) ?: 'desc'];

    $builder = $model->orderBy($o, $d);
    if ($filter && $search) {
      $builder->where(function ($builder) use ($search, $filter,$table) {
        foreach ((array)$search as $column) {
          /** @var Builder $builder */
          $builder->orWhere($table.'.'.$column, 'like binary', "%{$filter}%");
        }
      });
    }
    if ($closure) {
      $closure($builder);
    }

    $url = url()->current();

    $query = \Request::query();
    $query = http_build_query(array_except($query, 'page'));

    /** @var LengthAwarePaginator $pager */
    $pager = $builder->paginate($pageSize ?: 10)->setPath($url . '?' . $query);

    if ($trans) {
      $trans($pager->getCollection());
    }

    return $pager;
  }
}
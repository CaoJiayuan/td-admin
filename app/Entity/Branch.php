<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/**
 * App\Entity\Branch
 *
 * @property int $id
 * @property string $branch_id 单位编号
 * @property string $branch_name 单位名称
 * @property int $parent_id 上级单位ID
 * @property string $branch_internal_code 单位内部编号
 * @property int $status 0-已删除，1-已创建
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \App\Entity\Branch $parent
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Branch whereBranchId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Branch whereBranchInternalCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Branch whereBranchName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Branch whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Branch whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Branch whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Branch whereParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Branch whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Branch whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Branch extends Model
{
  use SoftDeletes;
  protected $dates = ['deleted_at'];
  protected $table = 'branchs';
  protected $fillable = ['branch_id', 'branch_name', 'parent_id', 'branch_internal_code'];

  public function parent()
  {
    return $this->belongsTo('App\Entity\Branch','parent_id');
  }
}

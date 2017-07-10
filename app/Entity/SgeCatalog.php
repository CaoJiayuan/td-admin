<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\SgeCatalog
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name 目录名称
 * @property bool $status 状态(0-已删除,1-可用)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\SgeCatalog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\SgeCatalog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\SgeCatalog whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\SgeCatalog whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\SgeCatalog whereUpdatedAt($value)
 */
class SgeCatalog extends Model
{
  protected $table = "SgeCatalogs";
  protected $fillable = [
    'id',
    'name',
    'status'
  ];
  public $timestamps = true;
}

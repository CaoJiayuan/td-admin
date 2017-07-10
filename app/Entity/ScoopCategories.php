<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\ScoopCategories
 *
 * @property string $id
 * @property string $name
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ScoopCategories whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\ScoopCategories whereName($value)
 * @mixin \Eloquent
 */
class ScoopCategories extends Model
{

  protected $table = "news_categories";
  protected $primaryKey = 'id';

  protected $keyType = 'string';

  protected $fillable = [
    'id',
    'name',
  ];

  public $timestamps = false;


}

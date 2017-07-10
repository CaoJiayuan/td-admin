<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Product
 *
 * @property int $id
 * @property string $name 产品名称
 * @property string $code 产品代码
 * @property bool $status 状态(0-已删除,1-可用)
 * @property string $content 产品内容
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Product whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Product whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Product whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Product whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Product whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    protected $fillable = [
        'id',
        'name',
        'code',
        'status',
        'content'
    ];
    public $timestamps = true;
}

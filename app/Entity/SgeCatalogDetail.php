<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Entity\SgeCatalogDetail
 *
 * @property int $id
 * @property int $sge_catalog_id 目录ID
 * @property string $question 问题
 * @property string $answer 答案
 * @property bool $status 状态(0-已删除,1-可用)
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\SgeCatalogDetail whereAnswer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\SgeCatalogDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\SgeCatalogDetail whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\SgeCatalogDetail whereQuestion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\SgeCatalogDetail whereSgeCatalogId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\SgeCatalogDetail whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\SgeCatalogDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SgeCatalogDetail extends Model
{
    protected $table = "sge_catalogs_details";
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'id',
        'sge_catalog_id',
        'question',
        'answer',
        'status'
    ];
}

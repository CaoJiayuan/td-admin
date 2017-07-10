<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Disclaimer
 *
 * @property int $id
 * @property string $title 网站标题
 * @property string $keyWords 关键字
 * @property string $content 内容
 * @property string $logo 网站logo
 * @property bool $type 0-关于我们,1-基本设置
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Disclaimer whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Disclaimer whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Disclaimer whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Disclaimer whereKeyWords($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Disclaimer whereLogo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Disclaimer whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Disclaimer whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Disclaimer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Disclaimer extends Model
{
    protected $table = 'about';
    protected $fillable = [
        'title',
        'keyWords',
        'content',
        'logo'
    ];
}

<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\Join
 *
 * @property int $id
 * @property string $position
 * @property string $describe
 * @property string $request
 * @property int $num
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property bool $status 状态
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Join whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Join whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Join whereDescribe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Join whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Join whereNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Join wherePosition($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Join whereRequest($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Join whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Join whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Join extends Model
{
  protected $table = 'join';
  protected $fillable = ['position', 'num', 'request', 'describe'];
  protected $dates = ['deleted_at'];
}

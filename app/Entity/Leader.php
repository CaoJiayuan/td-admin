<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Entity\Leader
 *
 * @property int $id
 * @property string $name
 * @property string $position
 * @property string $img
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property bool $status 状态
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Leader whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Leader whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Leader whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Leader whereImg($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Leader whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Leader wherePosition($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Leader whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Leader whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Leader extends Model
{
  use SoftDeletes;
  protected $fillable = ['name', 'img', 'status', 'position'];
  protected $hidden = ['updated_at', 'created_at'];
  protected $dates = ['deleted_at'];
}

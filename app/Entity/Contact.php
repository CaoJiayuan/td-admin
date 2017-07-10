<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Entity\Contact
 *
 * @property int $id
 * @property string $key
 * @property string $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property bool $status 状态
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Contact whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Contact whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Contact whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Contact whereKey($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Contact whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\Contact whereValue($value)
 * @mixin \Eloquent
 */
class Contact extends Model
{
  use SoftDeletes;
  protected $fillable = ['key', 'value'];
  protected $dates = ['deleted_at'];
}

<?php

namespace App;

use App\Entity\Branch;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Entity\Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $mobile 手机号
 * @property string $address
 * @property string $remarks
 * @property int $branch_id
 * @property-read \App\Entity\Branch $service
 * @method static \Illuminate\Database\Query\Builder|\App\User whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereBranchId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User whereRemarks($value)
 */
class User extends Authenticatable
{
  use Notifiable, EntrustUserTrait;

  protected $table = 'admins';

  protected $casts = [
    'edit_able'   => 'bool',
    'deletable' => 'bool'
  ];
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password','mobile', 'address', 'remarks', 'branch_id'
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token', 'updated_at'
  ];

  public function service()
  {
    return $this->belongsTo(Branch::class, 'branch_id', 'id');
  }

  public function resetRoles($roles)
  {
    $this->clearRoles()->attachRoles($roles);
  }

  public function clearRoles()
  {
    $this->roles()->detach();
    return $this;
  }
}

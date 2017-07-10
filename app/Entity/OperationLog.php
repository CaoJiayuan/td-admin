<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Entity\OperationLog
 *
 * @property int $id
 * @property int $admin_id 用户ID
 * @property string $operation 操作
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\OperationLog whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\OperationLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\OperationLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\OperationLog whereOperation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Entity\OperationLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OperationLog extends Model
{
    //
}

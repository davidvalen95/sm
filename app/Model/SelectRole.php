<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Model\SelectRole
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $key
 * @property string|null $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SelectRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SelectRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SelectRole whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SelectRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SelectRole whereValue($value)
 * @mixin \Eloquent
 */
class SelectRole extends Model
{
    //

    protected $table = 'select_role';
    protected $fillable = ['key','value'];
}

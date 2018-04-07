<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Previledge
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $key
 * @property string|null $value
 * @property int|null $isCanConfigureBranch
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Previledge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Previledge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Previledge whereIsCanConfigureBranch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Previledge whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Previledge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Previledge whereValue($value)
 * @mixin \Eloquent
 */
class Previledge extends Model
{
    //



    protected $table = 'previledge';
    protected $fillable = ['key','value','isCanConfigureBranch'];



}

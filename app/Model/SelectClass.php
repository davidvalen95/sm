<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\SelectClass
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $key
 * @property string|null $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SelectClass whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SelectClass whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SelectClass whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SelectClass whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SelectClass whereValue($value)
 * @mixin \Eloquent
 */
class SelectClass extends Model
{
    //

    protected $table = 'select_class';
    protected $fillable = ['key','value'];
}

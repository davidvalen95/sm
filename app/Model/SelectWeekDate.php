<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Model\SelectWeekDate
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $key
 * @property string|null $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SelectWeekDate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SelectWeekDate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SelectWeekDate whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SelectWeekDate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SelectWeekDate whereValue($value)
 * @mixin \Eloquent
 */
class SelectWeekDate extends Model
{
    //

    protected $table = 'select_week_date';
    protected $fillable = ['key','value'];
}

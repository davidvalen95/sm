<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Model\SelectEvent
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $key
 * @property string|null $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SelectEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SelectEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SelectEvent whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SelectEvent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\SelectEvent whereValue($value)
 * @mixin \Eloquent
 */
class SelectEvent extends Model
{
    //

    protected $table = 'select_event';
    protected $fillable = ['key','value'];
}

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

    /*
     * updateUser
     */

    protected $table = 'select_event';
    protected $fillable = ['key','value'];

    public function getHistories(){
        return $this->hasMany('\App\Model\History', 'select_event_id', 'id');
    }

    public static function getUpdateProfile(){
        return SelectEvent::where('value', 'updateUser')->first();
    }

    public static function getActivePupil(){
        return SelectEvent::where('value','activePupil')->first();
    }
    public static function getActiveTeacher(){
        return SelectEvent::where('value','activeTeacher')->first();
    }
    public static function getOffPupil(){
        return SelectEvent::where('value','offPupil')->first();
    }
    public static function getOffTeacher(){
        return SelectEvent::where('value','offTeacher')->first();
    }
    public static function getUpdateWebsite(){
        return SelectEvent::where('value','updateWebsite')->first();
    }
}

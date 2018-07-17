<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\AbsenceDate
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $targetDate
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AbsenceDate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AbsenceDate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AbsenceDate whereTargetDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AbsenceDate whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AbsenceDate extends Model
{
    //

    protected $table = "absence_date";
    protected $fillable = [
      'targetDate'
    ];


    public function getAbsenceBranches(){
        return $this->hasMany('App\Model\AbsenceBranch', 'absence_date_id', 'id');
    }



}

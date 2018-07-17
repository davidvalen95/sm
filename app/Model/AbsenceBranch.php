<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\AbsenceBranch
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int|null $isDone
 * @property int|null $select_class_id
 * @property int|null $branch_id
 * @property int|null $absence_date_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AbsenceBranch whereAbsenceDateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AbsenceBranch whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AbsenceBranch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AbsenceBranch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AbsenceBranch whereIsDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AbsenceBranch whereSelectClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AbsenceBranch whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $totalPupil
 * @property int $totalAbsence
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AbsenceBranch whereTotalAbsence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AbsenceBranch whereTotalPupil($value)
 * @property int|null $user_commiter_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\AbsenceBranch whereUserCommiterId($value)
 */
class AbsenceBranch extends Model
{
    //


    protected $table = "absence_branch";
    protected $fillable = [
        'isDone',

    ];


    public function getSelectClass(){
        return $this->belongsTo('App\Model\SelectClass', 'select_class_id', 'id');
    }
    public function getBranch(){
        return $this->belongsTo('App\Model\Branch', 'branch_id', 'id');
    }
    public function getAbsenceDate(){
        return $this->belongsTo('App\Model\AbsenceDate', 'absence_date_id', 'id');
    }

    public function getUserAbsenceRecord(){
        return $this->hasMany('App\Model\UserAbsenceRecord', 'absence_branch_id','id');
    }

    public function getUserCommiter(){
        return $this->belongsTo('App\Model\User', 'user_commiter_id', 'id');
    }


}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\UserAbsenceRecord
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $reason
 * @property int|null $branch_user_id
 * @property int|null $absence_branch_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAbsenceRecord whereAbsenceBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAbsenceRecord whereBranchUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAbsenceRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAbsenceRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAbsenceRecord whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAbsenceRecord whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $isFollowedUp
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\UserAbsenceRecord whereIsFollowedUp($value)
 */
class UserAbsenceRecord extends Model
{
    //

    protected $table = "user_absence_record";
    protected $fillable = [
        'reason',
    ];



    public function getAbsenceBranch(){
        return $this->belongsTo('App\Model\AbsenceBranch', 'absence_branch_id','id');
    }

    public function getBranchUser(){
        return $this->belongsTo('App\Model\BranchUser', 'branch_user_id','id');
    }






}

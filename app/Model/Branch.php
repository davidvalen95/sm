<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Parent_;

/**
 * App\Model\Branch
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $name
 * @property string|null $address
 * @property int|null $head_user_id
 * @property int|null $owner_users_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Branch whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Branch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Branch whereHeadUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Branch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Branch whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Branch whereOwnerUsersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Branch whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $owner_user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Branch whereOwnerUserId($value)
 */
class Branch extends Model
{
    //


    protected $table = 'branch';
    protected $fillable = ['name','address'];



    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[] of Branch
     */
    public static function getAllBranchSummary() {



        $branches = Branch::all();
        $latestAbsenceDate = AbsenceDate::all()->sortByDesc('created_at')->first();

        foreach($branches as $branch){

            $absenceBranches = $branch->getAbsenceBranches()->whereHas('getAbsenceDate',function($getAbsenceDate) use($latestAbsenceDate){
                $getAbsenceDate->where('absence_date_id',$latestAbsenceDate->id);
            })->get();

            $totalNotDone = 0;
            $totalPupil = 0;
            $totalAbsence = 0;
            $totalNotFollowedUp = 0;
            foreach($absenceBranches as $absenceBranch){
                $totalNotDone += $absenceBranch->isDone ? 0 : 1;
                $totalPupil += $absenceBranch->totalPupil;
                $totalAbsence += $absenceBranch->totalAbsence;

                $totalNotFollowedUp += $absenceBranch->getUserAbsenceRecord->where('isFollowedUp',false)->count();
            }
            $branch->totalNotDone = $totalNotDone;
            $branch->totalPupil = $totalPupil;
            $branch->totalAbsence = $totalAbsence;
            $branch->notYetFollowedUp = $totalNotFollowedUp;

            $availablePercentage = 0 ;

            try{
                $availablePercentage = ($totalPupil - $totalAbsence) / $totalPupil * 100;;
            }catch(\Exception $tes){

            }

            $branch->availablePercentage = $availablePercentage;

        }


        $branchSummaryReport = (object) [];

        $branchSummaryReport->data = $branches;
        $branchSummaryReport->latestAbsenceDate = $latestAbsenceDate;


        return $branchSummaryReport;


    }


    public function getOwner(){

        return $this->belongsTo('App\Model\User','owner_user_id','id');
    }
    public function getHead(){
        return $this->belongsTo('App\Model\User','head_user_id','id');

    }

    public function getBranchUsers(){
        return $this->hasMany('App\Model\BranchUser', 'branch_id','id');

    }



    public function getUsersAsTeacher(){
        return
            $this->getBranchUsers()->whereHas('getRole',function($role){
                $role->where('value','teacher');
            });
    }

    public function getUsersAsPupil(){
        return
            $this->getBranchUsers()->whereHas('getRole',function($role){
                $role->where('value','pupil');
            });
    }



    public function getAbsenceBranches(){
        return $this->hasMany('App\Model\AbsenceBranch', 'branch_id', 'id');
    }


    public function getBranchEvents(){
        return $this->hasMany("App\Model\BranchEvent","branch_id","id");
    }


    public function getPlannings(){
        return $this->hasMany("App\Model\Planning","branch_id","id");

    }


    public static function allNotMaster(){
        return Branch::where('name','!=','pusat')->get();
    }

    public function isMaster(){
        return strtolower($this->attributes['name']) == 'pusat';
    }
}

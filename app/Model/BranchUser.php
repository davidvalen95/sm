<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\BranchUser
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $isActive
 * @property string|null $dateIn
 * @property string|null $dateOut
 * @property int|null $branch_id
 * @property int|null $user_id
 * @property int|null $select_class_id
 * @property int|null $select_role_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchUser whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchUser whereDateIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchUser whereDateOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchUser whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchUser whereSelectClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchUser whereSelectRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchUser whereUserId($value)
 * @mixin \Eloquent
 */
class BranchUser extends Model
{
    //
    protected $table = 'branch_user';
    protected $fillable = ['isActive','dateIn','dateOut'];




    public function getClass(){

        return $this->belongsTo('App\Model\SelectClass','select_class_id');
    }


    public function getRole(){

        return $this->belongsTo('App\Model\SelectRole','select_role_id');
    }


    public function getBranch(){
        return $this->belongsTo('App\Model\Branch','branch_id','id');
    }



    public function getUser(){
        return $this->belongsTo('App\Model\User','user_id','id');
    }


    public function getUserAbsenceRecord(){
        return $this->hasMany('App\Model\UserAbsenceRecord', 'branch_user_id','id');
    }


    public static function addUniqueBranchUserAsTeacher(User $loggedInUser, User $user, Branch $branch, SelectRole $selectRole){


        $userAsTeacher = $user->getBranchUserAsTeacher()->whereHas('getBranch',function($userBranch) use($branch){
            $userBranch->where('id','=',$branch->id);
        });
        if($userAsTeacher->count() == 0){
            $newBranchUser = new BranchUser();
            $newBranchUser->getUser()->associate($user);
            $newBranchUser->getBranch()->associate($branch);
            $newBranchUser->getRole()->associate($selectRole);
            $newBranchUser->isActive = true;
            $newBranchUser->dateIn = getDefaultDatetime();
            $newBranchUser->getClass()->associate(SelectClass::where('value','yohanes')->first());
            $newBranchUser->save();


            $role = "";
            $event = null;
            if($selectRole->value == 'teacher'){
                $role = "GURU";
                $event = SelectEvent::getActiveTeacher();
            }
            if($selectRole->value == 'pupil'){
                $role = "MURID";
                $event = SelectEvent::getActivePupil();
            }

            addHistory($user,$event, "Masuk sebagai $role pada cabang $branch->name. Dimasukan oleh {$loggedInUser->name} - {$loggedInUser->nbg}");


            return true;
        }else{
            $userAsTeacherObject = $userAsTeacher->first();
            $userAsTeacherObject->isActive = true;
            $userAsTeacherObject->save();

//            return true;
        }

        return false;





    }


}

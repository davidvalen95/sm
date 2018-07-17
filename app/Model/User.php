<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Model\User
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $nbg
 * @property string|null $birthDate
 * @property string|null $address
 * @property string|null $phone
 * @property int|null $previledge_id
 * @property int|null $photo_id
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereNbg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User wherePhotoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User wherePreviledgeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'nbg', 'birthDate','address','phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

    }

    public function getPhoto(){

        return $this->belongsTo('App\Model\Photo','photo_id','id');
    }

    public function getPreviledge(){

        return $this->belongsTo('App\Model\Previledge','previledge_id','id');
    }


    public function getHistories(){
        return $this->hasMany('App\Model\History','user_id','id');
    }

    public function getMeAsPupilScores(){
        return $this->hasMany('App\Model\Score', 'pupil_user_id','id');
    }

    public function getMeAsTeacherScores(){
        return $this->hasMany('App\Model\Score', 'teacher_user_id','id');
    }
    public function getMeAsOwners(){
        return $this->hasMany('App\Model\Branch', 'owner_user_id','id');
    }
    public function getMeAsHead(){
        return $this->hasMany('App\Model\Branch', 'head_user_id','id');
    }

    public function getBranchUser(){
        return $this->hasMany('App\Model\BranchUser', 'user_id','id');

    }

    public function getThreads(){
        return $this->hasMany('App\Model\Thread', 'creator_user_id','id');
    }



    public function getReplies(){
        return $this->hasMany('App\Model\Reply','user_id','id');
    }


    public function getThreadsOpen(){
        return $this->belongsToMany('App\Model\Thread', 'thread_user','user_id','thread_id')
            ->withTimestamps();


    }




    public function getNameAttribute()
    {
        return  ucwords($this->attributes['name']);
    }

    public function getNbgAttribute()
    {
        return  ucwords($this->attributes['nbg']);
    }

    public function getPath(){
        createDirIfNotExist("public/image/user/$this->id/");
        return "public/image/user/$this->id/";
    }

    public function isMySelf(User $user){
        return $this->id == $user->id;
    }

    public function isMaster(){
        return $this->getPreviledge->value == 'master';
    }

    public function isTeacher(){
        return $this->getPreviledge->value == 'teacher';
    }
    public function isPupil(){
        return $this->getPreviledge->value == 'pupil';
    }


    public function isThisMyBranch(Branch $branch){

        return $this->getBranchUser()->whereHas('getBranch',function($getBranch) use ($branch){
            $getBranch->where('id', $branch->id);
        })->count() > 0;

    }

    public function getBranchUserAsTeacher(){
       return
       $this->getBranchUser()->whereHas('getRole', function($role){
           $role->where('value', 'teacher');
       });


    }
    public function getBranchUserAsAPupil(){
        return
            $this->getBranchUser()->whereHas('getRole', function($role){
                $role->where('value', 'pupil');
            });

    }

    public function isMeHeadBranch(){
        return Branch::where('head_user_id','=',$this->id)->count() > 0;
    }


    public function getAbsenceCommit(){

        return $this->hasMany("App\Model\AbsenceBranch", "user_commiter_id","id");
    }



}

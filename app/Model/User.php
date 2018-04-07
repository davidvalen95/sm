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


    public function getPhoto(){

        return $this->hasOne('App\Model\Photo','photo_id');
    }

    public function getPreviledge(){

        return $this->hasOne('App\Model\Previledge','previledge_id');
    }


    public function getHistories(){
        return $this->hasMany('App\Model\History','user_id','id');
    }

    public function getMeAsPupilScores(){
        return $this->hasMany('App\Model\Score', 'pupil_user_id','id');
    }

    public function getMeAsTeacherScores(){
        return $this->hasMany('App\Model\Scores', 'teacher_user_id','id');
    }
    public function getMeAsOwners(){
        return $this->hasMany('App\Model\Branch', 'owner_user_id','id');
    }
    public function getMeAsHead(){
        return $this->hasMany('App\Model\Branch', 'head_user_id','id');
    }

    public function getBranches(){
        return $this->hasMany('App\Model\BranchUser', 'user_id','id');

    }



}

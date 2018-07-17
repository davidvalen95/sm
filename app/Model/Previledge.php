<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Previledge
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $key
 * @property string|null $value
 * @property int|null $isCanConfigureBranch
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Previledge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Previledge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Previledge whereIsCanConfigureBranch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Previledge whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Previledge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Previledge whereValue($value)
 * @mixin \Eloquent
 * @property int $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Previledge whereUser($value)
 * @property int $allUser
 * @property int $pupil
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Previledge whereAllUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Previledge wherePupil($value)
 * @property int $allUserProfile
 * @property int $pupilProfile
 * @property int $pupilScore
 * @property int $website
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Previledge whereAllUserProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Previledge wherePupilProfile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Previledge wherePupilScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Previledge whereWebsite($value)
 * @property int $addPupil
 * @property int $addTeacher
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Previledge whereAddPupil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Previledge whereAddTeacher($value)
 */
class Previledge extends Model
{
    //



    protected $table = 'previledge';
    protected $fillable = ['key','value'];



}

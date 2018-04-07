<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Score
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $description
 * @property int|null $pupil_user_id
 * @property int|null $teacher_user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\hasOneModel\Score whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Score whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Score whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Score wherePupilUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Score whereTeacherUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Score whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Score extends Model
{
    //


    protected $table = 'score';
    protected $fillable = ['description'];



    public function getPupil(){
        return $this->belongsTo('App\Model\User','pupil_user_id');
    }


    public function getTeacher(){
        return $this->belongsTo('App\Model\User','teacher_user_id');
    }



}

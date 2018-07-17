<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\History
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $description
 * @property int|null $select_event_id
 * @property int|null $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\History whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\History whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\History whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\History whereSelectEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\History whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\History whereUserId($value)
 * @mixin \Eloquent
 */
class History extends Model
{
    //



    protected $table = 'history';
    protected $fillable = ['description'];



    public function getEvent(){

        return $this->belongsTo('App\Model\SelectEvent','select_event_id');
    }

    public function getUser(){

        return $this->belongsTo('App\Model\User','user_id','id');
    }


}

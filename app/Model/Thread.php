<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    //



    protected $table = 'thread';
    protected $fillable = ['title'];


    public function getLastReply(){
        return $this->belongsTo('App\Model\User','last_reply_user_id','id');
    }

    public function getCreator(){
        return $this->belongsTo('App\Model\User','creator_user_id','id');
    }


    public function getReplies(){
        return $this->hasMany('App\Model\Reply','thread_id','id');
    }


}

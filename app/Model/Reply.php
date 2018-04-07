<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    //



    protected $table = 'reply';
    protected $fillable = ['content'];


    public function getUser(){
        return $this->belongsTo('App\Model\User','user_id','id');
    }

    public function getThread(){
        return $this->belongsTo('App\Model\Thread','thread_id','id');
    }

    public function getAttachments(){
        return $this->hasMany('App\Model\Attachment','reply_id','id');

    }
}

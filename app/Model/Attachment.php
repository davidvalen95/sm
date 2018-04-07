<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    //

    protected $table = 'attachment';
    protected $fillable = ['path','name'];


    public function getReply(){
        return $this->belongsTo('App\Model\Reply','reply_id','id');
    }


}

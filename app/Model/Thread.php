<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Thread
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $title
 * @property int|null $last_reply_user_id
 * @property int|null $creator_user_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Thread whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Thread whereCreatorUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Thread whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Thread whereLastReplyUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Thread whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Thread whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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


    public function getUsersOpen(){
        return $this->belongsToMany('App\Model\User', 'thread_user','thread_id','user_id')
            ->withTimestamps();

    }


    private function public(){

        return ucwords($this->attributes['title']);
    }

}

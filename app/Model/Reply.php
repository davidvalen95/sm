<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Reply
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $content
 * @property int|null $user_id
 * @property int|null $thread_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Reply whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Reply whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Reply whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Reply whereThreadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Reply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Reply whereUserId($value)
 * @mixin \Eloquent
 */
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

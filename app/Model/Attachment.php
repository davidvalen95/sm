<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Attachment
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $path
 * @property string|null $name
 * @property int|null $reply_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Attachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Attachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Attachment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Attachment wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Attachment whereReplyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Attachment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Attachment extends Model
{
    //

    protected $table = 'attachment';
    protected $fillable = ['path','name'];


    public function getReply(){
        return $this->belongsTo('App\Model\Reply','reply_id','id');
    }


}

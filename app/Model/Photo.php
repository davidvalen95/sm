<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Photo
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $path
 * @property string|null $nameSm
 * @property string|null $nameLg
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Photo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Photo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Photo whereNameLg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Photo whereNameSm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Photo wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Photo whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $youtubeLink
 * @property int $type
 * @property int|null $branch_event_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Photo whereBranchEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Photo whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Photo whereYoutubeLink($value)
 */
class Photo extends Model
{
    //

    protected $table = 'photo';
    protected $fillable = ['path','nameSm','nameLg'];






    public function getBranchEvent(){
        return $this->belongsTo("App\Model\BranchEvent","branch_event_id","id");
    }
}

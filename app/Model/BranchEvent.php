<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\BranchEvent
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $title
 * @property string|null $description
 * @property int|null $branch_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchEvent whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchEvent whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchEvent whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchEvent whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $youtubeLink
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchEvent whereYoutubeLink($value)
 */
class BranchEvent extends Model
{
    //

    protected $table = "branch_event";

    protected $fillable = [
        "title",
        "youtubeLink",
        "description"
    ];




    public function getPhotos(){
        return $this->hasMany("App\Model\Photo","branch_event_id","id");
    }

    public function getBranch(){
        return $this->belongsTo("App\Model\Branch","branch_id","id");
    }



    public function getPath(){
        createDirIfNotExist("public/image/branch-event/$this->id/");
        return "public/image/branch-event/$this->id/";
    }


    public function getTitleAttribute(){
        return ucwords($this->attributes["title"]);
    }

}

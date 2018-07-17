<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Planning
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $title
 * @property string|null $description
 * @property string|null $dueDate
 * @property int|null $branch_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Planning whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Planning whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Planning whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Planning whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Planning whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Planning whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Planning whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Planning extends Model
{
    //

    protected $table = "planning";

    protected $fillable = [
        "title",
        "description",
        "dueDate",
    ];



    public function getBranch(){
        return $this->belongsTo("App\Model\Branch","branch_id","id");
    }
}

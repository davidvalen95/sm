<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\BranchUser
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property int $isActive
 * @property string|null $dateIn
 * @property string|null $dateOut
 * @property int|null $branch_id
 * @property int|null $user_id
 * @property int|null $select_class_id
 * @property int|null $select_role_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchUser whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchUser whereDateIn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchUser whereDateOut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchUser whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchUser whereSelectClassId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchUser whereSelectRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\BranchUser whereUserId($value)
 * @mixin \Eloquent
 */
class BranchUser extends Model
{
    //
    protected $table = 'branch_user';
    protected $fillable = ['isActive','dateIn','dateOut'];



    public function getUser(){
        return $this->belongsTo('App\Model\User','user_id','id');
    }

}

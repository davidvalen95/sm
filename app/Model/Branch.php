<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Branch
 *
 * @property int $id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $name
 * @property string|null $address
 * @property int|null $head_user_id
 * @property int|null $owner_users_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Branch whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Branch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Branch whereHeadUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Branch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Branch whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Branch whereOwnerUsersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Branch whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Branch extends Model
{
    //


    protected $table = 'branch';
    protected $fillable = ['name','address'];




    public function getOwner(){

        return $this->belongsTo('App\Model\User','owner_user_id','id');
    }
    public function getHead(){
        return $this->belongsTo('App\Model\User','head_user_id','id');

    }





}

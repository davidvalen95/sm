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
 */
class Photo extends Model
{
    //

    protected $table = 'photo';
    protected $fillable = ['path','nameSm','nameLg'];
}

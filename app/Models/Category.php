<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 09 Aug 2019 17:18:02 +0000.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * 
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $created_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $users
 *
 * @package App\Models
 */
class Category extends Model
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'category';

	protected $fillable = [
		'name', 'color'
	];

    protected $with = ['image'];

	public function users()
	{
		return $this->belongsToMany(\App\Models\User::class, 'user_category');					
	}

    public function image()
    {
        return $this->morphOne('App\Models\File', 'fileable');
    }

}

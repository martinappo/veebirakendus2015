<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'tags';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name'
	];

	/**
	 * Get the trainings associated with the given tag 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	*/
	public function trainings() {
		return $this->belongsToMany('App\Training', 'tag_training');
	}

}

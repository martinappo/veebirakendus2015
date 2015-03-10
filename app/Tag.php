<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

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

<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingFile extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'files';

	/**
	 * Get the training associated with the given file
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToOne
	*/
	public function training() {
		return $this->belongsTo('App\Training');
	}

}

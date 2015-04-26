<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'ratings';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'value',
		'user_id',
		'training_id'
	];

	/**
	 * Get the training associated with the given rating
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	*/
	public function training() {
		return $this->belongsTo('App\Training');
	}

	/**
	 * Get the user associated with the given rating
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	*/
	public function user() {
		return $this->belongsTo('App\User');
	}
}

<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'comments';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'content',
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

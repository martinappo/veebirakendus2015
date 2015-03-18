<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model {

	protected $table = 'trainings';

	protected $fillable = [
		'aadress',
		'title',
		'coordinates',
		'type',
		'description',
		'user_id',
		'confirmed'
	];

	/**
	 * Get trainings that are confrimed
	 * @param $query
	 * @return void
	 */
	public function scopeConfirmed($query) {
		$query->where('confirmed', '=', true);
	}

	/**
	 * Get trainings that are not confirmed
	 * @param $query
	 * @return void
	 */
	public function scopeNotConfirmed($query) {
		$query->where('confirmed', '=', false);
	}

	/**
	 * A training is owned by a user.
	 * @return \Illuminate\Database\Eloquent\Relations\BlongsTo
	*/
	public function user() {
		return $this->belongsTo('App\User');
	}

	/**
	 * Get the tags associated with training
	 * @return \Illuminate\Database\Eloquent\Relations\BlongsToMany
	*/
	public function tags() {
		return $this->belongsToMany('App\Tag', 'tag_training')->withTimestamps();
	}
	/**
	* Check if user is owner of the training
	*/
	public function isTheOwner($user) {
		return $this->user_id === $user->id;
	}

	/**
	* Get a list of tag ids associated with the current training
	* @return array
	*/
	public function getTagListAttribute() {
		return $this->tags->lists('id');
	}

}
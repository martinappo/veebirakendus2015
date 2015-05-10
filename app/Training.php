<?php namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class Training extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'trainings';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'aadress',
		'title',
		'longitude',
		'latitude',
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
	 * Get trainings with keywords
	 * @param $query
	 * @return void
	 */
	public function scopeKeywordSearch($query, $keywords) {
		if (!empty($keywords)) {
			foreach ($keywords as $keyword)
			{
				$query->orWhere('description', 'LIKE', '%'.$keyword.'%')
					->orWhere('title', 'LIKE', '%'.$keyword.'%');
			}
		}
	}

	/**
	 * Get trainings with given tags
	 * @param $query
	 * @return void
	 */
	public function scopeTagsSearch($query, $tags) {
		$query
			->join('tag_training', 'tag_training.training_id', '=', 'trainings.id')
			->whereIn('tag_training.tag_id', $tags)
			->groupBy('trainings.id');
	}

	/**
	 * Get trainings in radius
	 * @param $query
	 * @return void
	 */
	public function scopeFilterByRadius($query, $lat, $lon, $rad) {
		//Earth radius
		$R = 6371;
		// first-cut bounding box (in degrees)
		$maxLat = $lat + rad2deg($rad/$R);
		$minLat = $lat - rad2deg($rad/$R);
		// compensate for degrees longitude getting smaller with increasing latitude
		$maxLon = $lon + rad2deg($rad/$R/cos(deg2rad($lat)));
		$minLon = $lon - rad2deg($rad/$R/cos(deg2rad($lat)));

		$query->whereBetween('latitude', array($minLat, $maxLat))
		->whereBetween('longitude', array($minLon, $maxLon));
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
	 * A training can have many files
	*/
	public function files() {
		return $this->hasMany('App\TrainingFile');
	}

	/**
	 * A training can have many ratings
	*/
	public function ratings() {
		return $this->hasMany('App\Rating');
	}

	/**
	 * A training can have many comments
	*/
	public function comments() {
		return $this->hasMany('App\Comment');
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

	/**
	* Get training's average rating
	* @return float
	*/
	public function getAverageRating() {
		$average = 0;
		$ratings =  $this->ratings->lists('value');

		if (count($ratings))
		{
			$average = array_sum($ratings) / count($ratings);
		}
		return $average;
	}

}
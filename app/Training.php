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
			->groupBy('trainings.id')
			->orderBy(DB::raw('count(*)'), 'desc');
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
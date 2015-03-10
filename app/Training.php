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

	public function scopeConfirmed($query) {
		$query->where('confirmed', '=', true);
	}

	/**
		* A training is owned by a user.
	*/
	public function user() {
		return $this->belongsTo('App\User');
	}

	public function isTheOwner($user) {
		return $this->user_id === $user->id;
	}
}
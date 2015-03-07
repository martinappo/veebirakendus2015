<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Training extends Model {

	protected $table = 'trainings';

	protected $fillable = [
		'aadress',
		'title',
		'coordinates',
		'type',
		'description'
	];

	/**
		* A training is owned by a user.
	*/
	public function user() {
		return $this->belongsTo('App\User');
	}
}
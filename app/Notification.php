<?php namespace App;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'notifications';

	/**
	 * A notifcation is owned by a user.
	 * @return \Illuminate\Database\Eloquent\Relations\BlongsTo
	*/
	public function user() {
		return $this->belongsTo('App\User');
	}

}
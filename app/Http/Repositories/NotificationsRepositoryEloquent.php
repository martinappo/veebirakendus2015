<?php namespace App\Http\Repositories;

use App\Notification;
use App\User;

class NotificationsRepositoryEloquent implements NotificationsRepository
{
	protected $notificationsModel;

	public function __construct(Notification $notificationsModel)
	{
		$this->notificationsModel = $notificationsModel;
	}

	/**
	 * Adding new empty notification
	 * @param  array  $args
	 * @return Notification       [notification instance]
	 */
	public function newInstance(array $args = array())
	{
		return $this->$notificationsModel->newInstance($args);
	}

	/**
	 * Creating a new notification
	 * @param  User   $user    [The user whose notification it is]
	 * @param  [string] $title   [Title of the notif.]
	 * @param  [string] $message [Message of the notif.]
	 * @return [Notification]          [saved notification]
	 */
	public function create(User $user, $title, $message)
	{
		$this->notificationsModel->title = $title;
		$this->notificationsModel->content = $message;
		return $user->notifications()->save($this->notificationsModel);
	}

	/**
	 * Deletes notification from db
	 * @param  [int] $id [id of the notification]
	 * @return [bool]     [Success]
	 */
	public function destroy($id)
	{
		return $this->notificationsModel->destroy($id);
	}
}

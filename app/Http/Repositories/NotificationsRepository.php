<?php namespace App\Http\Repositories;
use App\User;

interface NotificationsRepository
{
	public function newInstance(array $args = array());

	public function create(User $user, $title, $message);

	public function createMany($users, $title, $message);

	public function destroy($id);
}

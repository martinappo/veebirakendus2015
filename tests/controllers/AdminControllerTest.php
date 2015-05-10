<?php

class AdminControllerTest extends TestCase {

	/**
	 * Testing index controller
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$user = new App\User(array('name' => 'John'));
		$user->role = 'admin';
		$this->be($user);

		$response = $this->action('GET', 'AdminController@index');

		$this->assertViewHas('trainings');
		$this->assertViewHas('users');
		$this->assertViewHas('userCount');
		$this->assertViewHas('trainingCount');
		$this->assertViewHas('notifications');

		$trainings = $response->original->getData()['trainings'];
		$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $trainings);

		$users = $response->original->getData()['users'];
		$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $users);

		$notifications = $response->original->getData()['notifications'];
		$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $notifications);
	}

	/**
	 * Testing index not authenticated
	 *
	 * @return void
	 */
	public function testIndexNotAuth()
	{
		$response = $this->action('GET', 'AdminController@index');

		$this->assertRedirectedTo('/home');
	}


	/**
	 * Testing index not admin
	 *
	 * @return void
	 */
	public function testIndexNotAdmin()
	{
		$user = new App\User(array('name' => 'John'));
		$this->be($user);

		$response = $this->action('GET', 'AdminController@index');

		$this->assertRedirectedTo('/');
	}

	/**
	 * Testing trainings method
	 *
	 * @return void
	 */
	public function testTrainings()
	{
		$user = new App\User(array('name' => 'John'));
		$user->role = 'admin';
		$this->be($user);

		$response = $this->action('GET', 'AdminController@trainings');

		$this->assertViewHas('trainings');
		$this->assertViewHas('tags');

		$trainings = $response->original->getData()['trainings'];
		$this->assertTrue(is_array($trainings));

		$tags = $response->original->getData()['tags'];
		$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $tags);
	}

	/**
	 * Testing users view
	 *
	 * @return void
	 */
	public function testUsers()
	{
		$user = new App\User(array('name' => 'John'));
		$user->role = 'admin';
		$this->be($user);

		$response = $this->action('GET', 'AdminController@users');

		$this->assertViewHas('users');

		$users = $response->original->getData()['users'];
		$this->assertTrue(is_array($users));
	}


}

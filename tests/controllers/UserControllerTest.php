<?php

class UserControllerTest extends TestCase {

	/**
	 * Testing index controller
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$user = new App\User(array('name' => 'John'));
		$this->be($user);

		$response = $this->action('GET', 'UserController@index');

		$this->assertViewHas('trainings');
		$this->assertViewHas('user');

		$trainings = $response->original->getData()['trainings'];
		$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $trainings);

		$user = $response->original->getData()['user'];
		$this->assertInstanceOf('App\User', $user);
	}

	/**
	 * Testing index not authenticated
	 *
	 * @return void
	 */
	public function testIndexNotAuth()
	{
		$response = $this->action('GET', 'UserController@index');

		$this->assertRedirectedTo('/home');
	}

}

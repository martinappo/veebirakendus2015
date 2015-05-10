<?php

class TrainingControllerTest extends TestCase {

	/**
	 * Testing index controller
	 *
	 * @return void
	 */
	public function testIndex()
	{
		$response = $this->action('GET', 'TrainingsController@index');

		$this->assertViewHas('trainings');
		$this->assertViewHas('tags');

		$trainings = $response->original->getData()['trainings'];
		$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $trainings);

		$tags = $response->original->getData()['tags'];
		$this->assertTrue(is_array($tags));
	}

	/**
	 * Testing create method
	 *
	 * @return void
	 */
	public function testCreate()
	{
		$user = new App\User(array('name' => 'John'));
		$this->be($user);

		$response = $this->action('GET', 'TrainingsController@create');

		$this->assertViewHas('tags');

		$tags = $response->original->getData()['tags'];
		$this->assertTrue(is_array($tags));
	}

	/**
	 * Testing create method without user
	 *
	 * @return void
	 */
	public function testCreateNotAuth()
	{
		$response = $this->action('GET', 'TrainingsController@create');

		$this->assertRedirectedTo('/home');
	}

	/**
	 * Testing getting trainings for map
	 *
	 * @return void
	 */
	public function testTrainingsForMap()
	{
		$response = $this->action('GET', 'TrainingsController@trainingsForMap');
		json_decode($response->getContent());

		$this->assertTrue(json_last_error() == JSON_ERROR_NONE);
	}

	/**
	 * Testing search
	 *
	 * @return void
	 */
	public function testSearch()
	{
		$response = $this->action('GET', 'TrainingsController@search');
		$this->assertViewHas('trainings');
	}



}

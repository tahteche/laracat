<?php


class ExampleTest extends TestCase {

	public function setUp() {
		parent::setUp();
		Artisan::call('migrate');
		$this->seed();
		Route::enableFilters();
	}

	public function testHomePageRedirection() {
		$this->call('GET', '/'); //What does call() do?
		$this->assertRedirectedTo('cats');

	}

	public function testVisitorIsRedirected() {
		$this->call('GET', '/cats/create');
		$this->assertRedirectedTo('login');
	}


/*This Test Fails with MassAssignmentException unless I 
put:

Artisan::call('migrate');
		$this->seed();

Find out why
*/
	public function testLoggedInUserCanCreateCat() {
		$user = new User(array('name' => 'John Doe', 
													 'is_admin' => false));
		$this->be($user);
		$this->call('GET', '/cats/create');
		$this->assertResponseOk();

	}


	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testBasicExample()
	{
		$crawler = $this->client->request('GET', 'http://localhost:8000/cats');

		$this->assertTrue($this->client->getResponse()->isOk());
	}

}

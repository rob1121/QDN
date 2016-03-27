<?php

class ExampleTest extends TestCase {
	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testOpenarchitectureIsHandmade() {
		$this->visit('/');
		$this->type('801', 'employee_id');
		$this->type('admin', 'password');
		$this->press('Login');
		$this->seePageIs('/home');
	}

}

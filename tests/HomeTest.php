<?php

class HomeTest extends TestCase
{
	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function test_a_visit_to_homepage_of_qdn()
    {
		$this->visit('/');
		$this->type('801', 'employee_id');
		$this->type('admin', 'password');
		$this->press('Login');
		$this->seePageIs('/home');
	}

}

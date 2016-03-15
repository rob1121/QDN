<?php

class ExampleTest extends TestCase {
	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testBasicExample() {
		$this->visit('/')
			->see('The Simple Way to Monitor Quality Hits')
			->type('801', 'employee_id')
			->type('legaspi', 'password')
			->press('Login')
			->see('Logout');
	}

}

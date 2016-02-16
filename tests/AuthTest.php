<?php

use App\User;

class AuthTest extends TestCase {
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testExample() {
		$this->assertTrue(true);

		$user = new User(['employee_id' => 27]);

		$this->be($user);
	}
}

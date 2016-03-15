<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class HomeTest extends TestCase {
	use WithoutMiddleware;
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testHomeVisit() {
		$this->visit('/');
	}
}

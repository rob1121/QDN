<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    /**
     * test user login form
     */
    public function testLogin()
    {
         $this->visit('/')
            ->type('robinson.legaspi@yahoo.com', 'email')
            ->type('123456', 'password')
            ->press('Login')
            ->seePageIs('/');
    }
}

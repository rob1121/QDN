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
        $this->loginFakeUser();
        $this->see('/home');
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_a_visit_to_homepage_of_qdn_and_should_fail()
    {
        $this->visit('/');
        $this->type('falseUserId', 'employee_id');
        $this->type('wrongpassword', 'password');
        $this->press('Login');
        $this->seePageIs('/');
    }

}

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
        $this->employee = factory(App\Employee::class)->create();
        $this->employee->user()->create($this->employee->toArray());

        $user = $this->employee->user;

        $this->visit('/');
        $this->type($user->employee_id, 'employee_id');
        $this->type('password', 'password');
        $this->press('Login');
        $this->see('/home');
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_a_visit_to_homepage_of_qdn_and_should_fail()
    {
        $this->employee = factory(App\Employee::class)->create();
        $this->employee->user()->create($this->employee->toArray());

        $this->visit('/');
        $this->type($this->employee->user->employee_id, 'employee_id');
        $this->type('wrongpassword', 'password');
        $this->press('Login');
        $this->seePageIs('/');
    }

}

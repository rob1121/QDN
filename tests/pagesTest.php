<?php

class pagesTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_a_visit_home_page_and_user_is_not_log_in()
    {
        $this->visit('/home');
        $this->seePageIs('/');
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_a_visit_home_page_and_user_is_log_in()
    {
        $this->loginFakeUser();
        $this->visit('/home');
        $this->assertResponseOk();
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_a_visit_dashboard_and_login_as_admin()
    {
        $this->loginAsAdmin();
        $this->visit('/dashboard');
        $this->assertResponseOk();
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function test_a_visit_on_gibberish_uri()
    {
        $this->get('/RandomRouteNameThatIsNotRegisteredOnOutRoute');
        $this->assertResponseStatus(404);
    }
}

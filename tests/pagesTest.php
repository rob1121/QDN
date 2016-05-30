<?php

class pagesTest extends TestCase
{
    public function test_a_visit_home_page_and_user_is_not_log_in()
    {
        $this->visit('/home');
        $this->seePageIs('/');
    }

    public function test_a_visit_home_page_and_user_is_log_in()
    {
        $this->loginFakeUser();
        $this->visit('/home');
        $this->assertResponseOk();
    }

    public function test_a_visit_dashboard_and_login_as_admin()
    {
        $this->loginAsAdmin();
        $this->visit('/dashboard');
        $this->assertResponseOk();
    }

    public function test_a_visit_dashboard_and_login_as_user()
    {
        $this->loginFakeUser();
        $this->visit('/dashboard');
        $this->assertResponseStatus(200);
    }
    
    public function test_a_visit_on_gibberish_uri()
    {
        $this->get('/RandomRouteNameThatIsNotRegisteredOnOutRoute');
        $this->assertResponseStatus(404);
    }
}

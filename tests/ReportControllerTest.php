<?php



class ReportControllerTest extends TestCase
{
    public function test_a_method_pdf()
    {
        $info = factory(App\Models\Info::class)->create();

        $this->loginAsAdmin();
        $this->visit('/report/' . $info->slug . '/pdf');
        $this->assertResponseOk();
    }

    public function test_a_method_report()
    {
        $this->loginFakeUser();
        $this->visit('/report');

        $this->see('QDN Issuance');
    }
}

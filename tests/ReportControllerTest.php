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

    public function test_a_method_should_store_data_to_database()
    {
        $data = factory(App\Models\Info::class)->make();

        $this->loginFakeUser(); //login dummy account
        $this->json('POST','/report', $data->toArray());
        $this->seeInDatabase([
            'customer' =>  $data->customer,
            'package_type' =>  $data->package_type,
            'device_name' =>  $data->device_name
        ]);
    }
}

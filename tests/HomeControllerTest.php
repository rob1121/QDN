<?php


use App\repo\HomeRepository;
use Carbon\Carbon;

class HomeControllerTest extends TestCase
{
    public function test_index_and_for_home_method()
    {
        $this->loginFakeUser();
        $this->visit('/home');
        $this->see('Incomplete');
    }

    public function test_index_and_for_home_without_auth()
    {
        $this->visit('/home');
        $this->see('The Simple Way to Monitor Quality Hits');
    }

    public function test_a_method_ajax_from_home_controller()
    {
        $year = Carbon::now('Asia/Manila')->year;
        $expected = ['failureMode', 'assembly', 'environment', 'machine', 'man', 'material', 'process'];

        $this->json('GET', route('ajax'), ['month' => '', 'year' => $year]);
        $this->seeJsonStructure($expected);
    }

    public function test_a_method_ajax_status()
    {
        $this->json('GET', route('status'), ['status' => 'closed']);
        $this->assertViewHas('tbl');
    }

    public function test_a_method_qdn_data()
    {
        $this->json('GET', route('qdn_data'), ['setDate' => 'today']);
        $this->assertResponseOk();
    }

    public function test_a_method_counter()
    {
        $expected = ['today', 'week', 'month', 'year', 'PeVerification', 'Incomplete', 'Approval', 'QaVerification'];

        $this->json('GET', route('counter'), []);
        $this->seeJsonStructure($expected);
    }

}

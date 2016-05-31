<?php

use Carbon\Carbon;

class ParetoControllerTest extends TestCase
{

    public function test_a_method_pareto()
    {
        $inputs = ['month' => '', 'year' => '2016', 'category' => 'year'];
        $expected = ['table', 'SelectedYear', 'FailureModes', 'DiscrepancyCategories'];

        $this->loginAsAdmin();
        $this->json('GET', route('pareto'), $inputs);
        $this->assertViewHas($expected);
    }

    public function test_a_method_ajax_pareto()
    {
        $inputs = [
            'sort' => 'ASC', 
            'column' => 'control_id',
            'text' => '',
            'start' => 10,
            'end' => 15,
            'year' => Carbon::now('Asia/Manila')->year,
            'month' => '',
            'discrepancy' => '',
            'FailureMode' => ''
            
        ];
        
        $expected = ["column", "tbl", "sort"];

        $this->loginAsAdmin();
        $this->json('GET', route('paretoAjax'), $inputs);
        $this->assertViewHas($expected);
    }
    
}

<?php

namespace App\Http\Controllers\Admin\Option;

use App\Http\Controllers\Controller;
use App\OptionModels\Option;
use Illuminate\Http\Request;
use App\repo\Option\CustomerRepo;

class CustomerController extends Controller {
	private $customer;

    public function __construct(CustomerRepo $customer){
		$this->customer = $customer;
    }

	public function CustomerOptions() {
		$customers = $this->customer->setup();
		return view('admin.pages.customer', compact('customers'));
	}

	public function updateCustomerOptions(Request $request) {
		return $this->customer->update($request->customer);
	}

	public function removeCustomerOptions(Request $request) {
		$this->customer->delete($request->customer);
	}
}

<?php

namespace App\Http\Controllers\Admin\Option;

use App\Http\Controllers\Controller;
use App\OptionModels\Machine;
use App\repo\Option\MachineRepo;
use Illuminate\Http\Request;

class MachineController extends Controller {
	public $machine;

	public function __construct(MachineRepo $machine) {
		$this->middleware('admin');
		$this->machine = $machine;
	}

	public function MachineOptions() {
		$machines = $this->machine->setup();
		return view('admin.pages.machine', compact('machines'));
	}

	public function updateMachineOptions(Request $request) {
		return $this->machine->update($request->name);
	}

	public function removeMachineOptions(Request $request) {
		$this->machine->delete($request->name);
	}
}

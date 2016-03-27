<?php

namespace App\repo\Option;
use App\OptionModels\Machine;
use JavaScript;

class MachineRepo {
	public function all() {
		return Machine::all();
	}

	public function get($name) {
		return Machine::where('name', $name)->first();
	}

	public function setup() {
		$machines = $this->all();
		$this->links($machines);
		return $machines;
	}

	public function links($query) {
		JavaScript::put('machines', $query);
		JavaScript::put('links', [
			'removeMachineOptions' => route('removeMachineOptions'),
			'updateMachineOptions' => route('updateMachineOptions'),
		]);
	}

	public function store($name) {
		Machine::create(['name' => $name]);
	}

	public function delete($name) {
		Machine::whereName($name)->delete();
	}

	public function update($name) {
		$machine = $this->get($name);
		if (!$machine) {
			$this->store($name);
		}
		return $machine ? 'exist' : 'unique';
	}
}
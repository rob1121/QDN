<?php

namespace App\repo\Option;
use App\OptionModels\Machine;
use JavaScript;

class MachineRepo {
	/**
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
	public function all() {
		return Machine::all();
	}

	/**
	 * @param $name
	 * @return mixed
     */
	public function get($name) {
		return Machine::where('name', $name)->first();
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
	public function setup() {
		$machines = $this->all();
		$this->links($machines);
		return $machines;
	}

	/**
	 * @param $query
     */
	public function links($query) {
		JavaScript::put([
			'machines'=> $query,
			'links'=> [
				'removeMachineOptions' => route('removeMachineOptions'),
				'updateMachineOptions' => route('updateMachineOptions'),
			]
		]);
	}

    /**
     * @param $name
     */
    public function store($name) {
		Machine::create(['name' => $name]);
	}

    /**
     * @param $name
     */
    public function delete($name) {
		Machine::whereName($name)->delete();
	}

    /**
     * @param $name
     * @return string
     */
    public function update($name) {
		$machine = $this->get($name);
		if (!$machine) {
			$this->store($name);
		}
		return $machine ? 'exist' : 'unique';
	}
}
<?php

namespace App\repo\Option;
use App\OptionModels\Discrepancy;
use JavaScript;

class DiscrepancyRepo {
	public function all() {
		return Discrepancy::all();
	}

	public function get($discrepancy) {
		return Discrepancy::whereName($discrepancy)->first();
	}

	public function setup() {
		$discrepancy = $this->all();
		$this->links($discrepancy);
	}

	public function links($query) {
		JavaScript::put('discrepancies', $query);
		JavaScript::put('categories', $query->unique('category'));
		JavaScript::put('links', [
			'removeDiscrepancy' => route('removeDiscrepancy'),
			'updateDiscrepancy' => route('updateDiscrepancy'),
		]);
	}

	public function store($request) {
		return Discrepancy::create($request->all());
	}

	public function delete($discrepancy) {
		Discrepancy::whereName($discrepancy)->delete();
	}

	public function update($request) {
		$discrepancy = $this->get($request->name);
		if (!$discrepancy) {
			return $this->store($request);
		}
	}
}
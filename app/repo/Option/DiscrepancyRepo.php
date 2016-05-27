<?php

namespace App\repo\Option;
use App\OptionModels\Discrepancy;
use JavaScript;

class DiscrepancyRepo {
	/**
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
	public function all() {
		return Discrepancy::all();
	}

    /**
     * @param $discrepancy
     * @return mixed
     */
    public function get($discrepancy) {
		return Discrepancy::whereName($discrepancy)->first();
	}

    public function setup() {
		$discrepancy = $this->all();
		$this->links($discrepancy);
	}

    /**
     * @param $query
     */
    public function links($query) {
		JavaScript::put([
			'discrepancies' => $query,
			'categories' => $query->unique('category'),
			'links'=> [
				'removeDiscrepancy' => route('removeDiscrepancy'),
				'updateDiscrepancy' => route('updateDiscrepancy'),
			]
		]);
	}

    /**
     * @param $request
     * @return static
     */
    public function store($request) {
		return Discrepancy::create($request->all());
	}

    /**
     * @param $discrepancy
     */
    public function delete($discrepancy) {
		Discrepancy::whereName($discrepancy)->delete();
	}

    /**
     * @param $request
     * @return DiscrepancyRepo
     */
    public function update($request) {
		$discrepancy = $this->get($request->name);
		if (!$discrepancy) {
			return $this->store($request);
		}
	}
}
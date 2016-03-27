<?php

namespace App\repo\Option;
use App\OptionModels\Discrepancy;
use App\OptionModels\Station;
use JavaScript;

class DiscrepancyRepo {
    public function all() {
        return Discrepancy::all();
    }

    public function get($station) {
        return Discrepancy::whereStation($station)->first();
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
        return Station::create($request->all());
    }

    public function delete($station) {
        Station::whereStation($station)->delete();
    }

    public function update($request) {
        $station = $this->get($request->station);
        if (!$station) {
           return $this->store($request);
        }
    }
}
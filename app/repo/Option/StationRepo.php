<?php

namespace App\repo\Option;
use App\OptionModels\Station;
use JavaScript;

class StationRepo {
    public function all() {
        return Station::all();
    }

    public function get($station) {
        return Station::whereStation($station)->first();
    }

    public function setup() {
        $stations = $this->all();
        $this->links($stations);
        return $stations;
    }

    public function links($query) {
        JavaScript::put('stations', $query);
        JavaScript::put('links', [
            'removeStationOptions' => route('removeStationOptions'),
            'updateStationOptions' => route('updateStationOptions'),
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
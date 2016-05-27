<?php

namespace App\repo\Option;
use App\OptionModels\Station;
use JavaScript;

class StationRepo {
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function all() {
        return Station::all();
    }

    /**
     * @param $station
     * @return mixed
     */
    public function get($station) {
        return Station::whereStation($station)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function setup() {
        $stations = $this->all();
        $this->links($stations);
        return $stations;
    }

    /**
     * @param $query
     */
    public function links($query) {
        JavaScript::put(['stations' => $query,
            'links' => [
                'removeStationOptions' => route('removeStationOptions'),
                'updateStationOptions' => route('updateStationOptions'),
            ]
        ]);
    }

    /**
     * @param $request
     * @return static
     */
    public function store($request) {
        return Station::create($request->all());
    }

    /**
     * @param $station
     */
    public function delete($station) {
        Station::whereStation($station)->delete();
    }

    /**
     * @param $request
     * @return StationRepo
     */
    public function update($request) {
        $station = $this->get($request->station);
        if (!$station) {
           return $this->store($request);
        }
    }
}
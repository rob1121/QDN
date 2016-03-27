<?php

namespace App\Http\Controllers\Admin\Option;

use App\Http\Controllers\Controller;
use App\OptionModels\Station;
use App\repo\Option\StationRepo;
use Illuminate\Http\Request;

class StationController extends Controller {
    public $station;

    public function __construct(StationRepo $station) {
        $this->middleware('admin');
        $this->station = $station;
    }

    public function StationOptions() {
        return view('admin.pages.station')->with('stations',$this->station->setup());
    }

    public function updateStationOptions(Request $request) {
        return $this->station->update($request);
    }

    public function removeStationOptions(Request $request) {
        $this->station->delete($request->station);
    }
}

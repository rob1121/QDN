<?php

namespace App\Http\Controllers\Admin\Option;

use Illuminate\Http\Request;
use App\repo\Option\DiscrepancyRepo;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DiscrepancyController extends Controller
{
    private $discrepancy;

    public function __construct(DiscrepancyRepo $discrepancy){
        $this->middleware('admin');
        $this->discrepancy = $discrepancy;
    }

    public function discrepancy() {
        $this->discrepancy->setup();
        return view('admin.pages.discrepancy');
    }

    // public function updateDiscrepancy(Request $request) {
    //     return $this->station->update($request);
    // }

    // public function removeDiscrepancy(Request $request) {
    //     $this->station->delete($request->station);
    // }
}

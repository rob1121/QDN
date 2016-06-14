<?php

namespace App\Http\Controllers\Api;

use App\repo\API\Api;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * @var Api
     */
    private $api;

    public function __construct(Api $api)
    {

        $this->api = $api;
    }
    public function cycleTime()
    {
        return toObject($this->api->cycleTime());
    }

    public function average()
    {
        return $this->api->cycleTimeAverage();
    }

    public function cycleTimePareto()
    {
        return $this->api->cycleTimePareto();
    }

    public function stationPie()
    {
        return $this->api->stationPie();
    }
}

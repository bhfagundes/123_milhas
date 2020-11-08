<?php

namespace App\Http\Controllers;
use App\Services\BusinessFlightsService;
class FlightController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function index()
    {
        $businessService = new BusinessFlightsService();
        return json_encode($businessService->formatResult());

    }
    //
}

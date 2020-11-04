<?php

namespace App\Http\Controllers;
use App\Services\MilhasService;
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
        $milhas = new MilhasService();
        dd($milhas->getAllFlights());
    }
    //
}

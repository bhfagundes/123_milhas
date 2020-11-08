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
      /**
  * @OA\Get(
  *   path="/",
  *   summary="Return the list flight agrouped",
  *   tags={"Hello"},
  *
   *    @OA\Response(
  *      response=200,
  *      description="List of flights",
  *      @OA\JsonContent(
  *        @OA\Property(
  *          property="data",
  *          description="List of flights by parameter",
  *
  *        )
  *      )
  *    )
  * )
  */
    public function index()
    {
        $businessService = new BusinessFlightsService();
        return $businessService->formatResult();

    }
    //
}

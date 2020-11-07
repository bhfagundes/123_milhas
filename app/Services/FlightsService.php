<?php

namespace App\Services;

use App\Factory\GuzzleFactory;

class FlightsService
{
    private $urlApi;

    public function __construct()
    {
        $this->urlApi = env("URL_API_MILHAS", "http://prova.123milhas.net");

    }

    public function getAllFlights()
    {
        $url = $this->urlApi . "/api/flights";
        return  GuzzleFactory::createGetRequisition($url);
    }

    public function  getFilterFlights($parameter)
    {
        $url = $this->urlApi . "/api/flights";
        $url = $url . "/" . $parameter;
        return  GuzzleFactory::createGetRequisition($url);
    }

}

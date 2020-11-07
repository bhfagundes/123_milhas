<?php

namespace App\Services;

use stdClass;

class BusinessFlightsService
{
    private $flights;

    public function __construct()
    {
        $flights = new FlightsService();
        $this->flights = $flights->getAllFlights();

    }
    public function groupByFareInboundOutbound()
    {
        $arrInbound = [];
        $arrOutbound = [];
        $response = new stdClass();
        for($i=0;$i<sizeof($this->flights);$i++)
        {
            if($this->flights[$i]->inbound == 1)
            {
                array_push($arrInbound[$this->flights[$i]->fare],$i);
            }
            else
            {
                array_push($arrOutbound[$this->flights[$i]->fare],$i);
            }
        }
        $response->inbound = $arrInbound;
        $response->outbound = $arrOutbound;
        return $response;
    }
    public function priceCombinedFare($data)
    {
        $result = [];
        $sums = [];
        $elements = new stdClass();
        foreach ($data->inbound as $key => $value)
        {
            for ($i=0;$i<sizeof($data->inbound[$key]);$i++)
            {
                for($j=0; $j<sizeof($data->outbound[$key]);$j++)
                {
                    $sum = $data->outbound[$key][$j]->price + $data->inbound[$key][$i]->price;
                    $elements->inbound = $data->inbound[$key][$i];
                    $elements->outbound  = $data->outbound[$key][$j];
                    array_push($result[$key][$sum],$elements);
                    array_push($sums,$sum);
                }
            }
        }

    }
    public function firstCriteria()
    {
        $originDestiny=[];
        $i=0;
        for ($i=0;$i<sizeof($this->flights);$i++)
        {

        }
    }



}

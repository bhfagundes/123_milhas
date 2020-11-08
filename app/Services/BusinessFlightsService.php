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
        $inboundFarePrice = [];
        $outboundFarePrice = [];
        $dataResult = new stdClass();
        $i=0;

        for ($i=0;$i<sizeof($this->flights);$i++)
        {
            if($this->flights[$i]->inbound ==1)
            {
                $inboundFarePrice[$this->flights[$i]->fare][$this->flights[$i]->price][] =$this->flights[$i];
            }
            else
            {
                $outboundFarePrice[$this->flights[$i]->fare][$this->flights[$i]->price][] =$this->flights[$i];
            }
        }
        $dataResult->inbound = $inboundFarePrice;
        $dataResult->outbound = $outboundFarePrice;
        return $dataResult;
    }
    public function generateResult()
    {
        $result = $this->firstCriteria();
        $groupResult = [];
        $resultSend=[];
        foreach ($result->inbound as $key => $value)
        {
            $groupResult[$key] = new stdClass();
            foreach($value as $index => $data)
            {

                $groupResult[$key]->inbound[] = $data;
            }
            foreach($result->outbound[$key]  as $index => $data)
            {

                $groupResult[$key]->outbound[] = $data;
            }
        }
        foreach ($groupResult as $key => $value)
        {
            for($i=0; $i<sizeof($groupResult[$key]->inbound);$i++)
            {
                for ($j=0 ;$j<sizeof($groupResult[$key]->outbound);$j++)
                {
                    $lenghtOutbound = (int)sizeof($groupResult[$key]->outbound);
                    $jMath = (int)$j;
                    $index = $key . "-" . (int)(($lenghtOutbound * $i) + $jMath);
                    $resultSend[$index] = new stdClass();
                    $resultSend[$index]->inbound = $groupResult[$key]->inbound[$i];
                    $resultSend[$index]->outbound = $groupResult[$key]->outbound[$j];
                }

            }
        }
        return $resultSend;
    }
    public function formatResult()
    {
        $price=0;
        $totalGroups=0;
        $totalFlights =0;
        $cheapestPrice =0;
        $cheapestGroup=0;
        $minPrice =0;
        $result = $this->generateResult();
        $totalGroups = sizeof($result);
        $i =0;
        $totalFlights  = sizeof($this->flights);
        $groups=[];
        $response=[];
        foreach($result  as $index => $data)
        {
            if($i==0)
            {
                $cheapestPrice = $data->inbound[0]->price  + $data->outbound[0]->price;
                $cheapestGroup = $index;
            }
            if($data->inbound[0]->price  + $data->outbound[0]->price < $cheapestPrice)
            {
                $cheapestGroup = $index;
                $cheapestPrice = $data->inbound[0]->price  + $data->outbound[0]->price;

            }
            $groups[$i]['uniqueId'] = $index;
            $groups[$i]['totalPrice']=$data->inbound[0]->price  + $data->outbound[0]->price;
            $groups[$i]['outbound']=[];
            for($j=0;$j<sizeof($data->inbound);$j++)
            {
                $groups[$i]['outbound'][]['id'] = $data->inbound[$j]->id;
            }
            for($j=0;$j<sizeof($data->outbound);$j++)
            {
                $groups[$i]['inbound'][]['id'] = $data->outbound[$j]->id;
            }
            $i++;
        }
        $response['flights'] = $this->flights;
        $response['groups']=$groups;
        $response['totalGrups']=$totalGroups;
        $response['totalFlights']=$totalFlights;
        $response['cheapestPrice']=$cheapestPrice;
        $response['cheapestGroup']=$cheapestGroup;
        return $response;
    }




}

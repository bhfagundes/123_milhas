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
    public function orderGroup($groups)
    {
        $arrPrice = [];
        $arrFlag = [];
        $response = [];
        for($i=0;$i<sizeof($groups);$i++)
        {
            $arrPrice[]=$groups[$i]['totalPrice'];
        }
        sort($arrPrice);
        for($i=0;$i<sizeof($arrPrice);$i++)
        {
            for($j=0; $j<sizeof($groups);$j++)
            {
                if($groups[$j]['totalPrice'] == $arrPrice[$i] &&  !in_array($j,$arrFlag))
                {
                    $arrFlag[]=$j;
                    $response[$i] = $groups[$j];
                    $j = sizeof($groups);
                }
            }
        }
        return $response;
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
        $response['groups']=$this->orderGroup($groups);
        $response['totalGrups']=$totalGroups;
        $response['totalFlights']=$totalFlights;
        $response['cheapestPrice']=$cheapestPrice;
        $response['cheapestGroup']=$cheapestGroup;
        return $response;
    }




}

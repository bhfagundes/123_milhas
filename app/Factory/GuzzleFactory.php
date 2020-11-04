<?php

namespace App\Factory;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Classe responsável por encapsular as gerações de 'Guzzle' do sistema.
 *
 * @author Brenner Fagundes
 */
class GuzzleFactory
{
    /**
     * @param $url
     * @param $request
     * @param bool $authorization
     * @return mixed
     */
    public static function createGetRequisition($url)
    {
        $client =  new Client();
        $response = $client->request('GET',$url);
        $body = $response->getBody();
        $content = $body->getContents();
        return json_decode($content);
    }
}

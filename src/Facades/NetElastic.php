<?php

namespace Gmedia\IspSystem\Facades;

use Gmedia\IspSystem\Models\ProductRouter;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request as GuzzleRequest;

class NetElastic
{
    public static function clear_log(ProductRouter $router)
    {
        $log = applog('erp, net_elastic__fac, clear_log');
        $log->save('debug');

        $url = 'https://'.$router->host;
        $status = false;
        $token = false;

        // login
        $request = new GuzzleRequest('POST', $url.'/v1/user/login', [
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
        ], json_encode([
            'password' => $router->pass,
            'userName' => $router->user,
        ]));

        $response = (new GuzzleClient(['verify' => false]))->sendRequest($request);
        $status = $response->getStatusCode();

        if (! ($status >= 200)) {
            return false;
        }

        $response_header = $response->getHeaders();
        $token = $response_header['Authorization'][0];

        // get bngs
        $request = new GuzzleRequest('GET', $url.'/v1/bngs', [
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => $token,
        ]);
        $response = (new GuzzleClient(['verify' => false]))->sendRequest($request);
        $status = $response->getStatusCode();

        if (! ($status >= 200)) {
            return false;
        }

        $response_body = json_decode($response->getBody()->getContents());
        $bngs = $response_body;

        if ($bngs->count < 1) {
            return false;
        }
        foreach ($bngs->result as $bng) {
            // clearonlinefailrecord
            $request = new GuzzleRequest('POST', $url.'/v1/bng/clearonlinefailrecord', [
                'accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => $token,
            ], json_encode([
                'id' => $bng->id,
                'bngId' => $bng->id,
            ]));
            $response = (new GuzzleClient(['verify' => false]))->sendRequest($request);
            $response_body = json_decode($response->getBody()->getContents());

            // clearabnormalofflinerecord
            $request = new GuzzleRequest('POST', $url.'/v1/bng/clearabnormalofflinerecord', [
                'accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => $token,
            ], json_encode([
                'id' => $bng->id,
                'bngId' => $bng->id,
            ]));
            $response = (new GuzzleClient(['verify' => false]))->sendRequest($request);
            $response_body = json_decode($response->getBody()->getContents());
        }

        return true;
    }
}

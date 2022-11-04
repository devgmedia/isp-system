<?php

namespace Gmedia\IspSystem\Facades;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request as GuzzleRequest;

class Whatsapp
{
    public static function send(
        $template_name,
        $parameters,
        $phone_number,
        $components = null,
        $callback = false
    ) {
        $log = applog('erp, whatsapp__fac, send');
        $log->save('debug');

        $url = 'https://multichannel.qiscus.com/whatsapp/v1/'.config('qiscus.app_code').'/'.config('qiscus.channel_id').'/messages';

        if (! $components) {
            $components = [
                [
                    'type' => 'body',
                    'parameters' => $parameters,
                ],
            ];
        }

        $log->new()->properties($template_name)->save('template_name');
        $log->new()->properties($phone_number)->save('phone_number');
        $log->new()->properties($components)->save('components');

        $request = new GuzzleRequest('POST', $url, [
            'Qiscus-App-Id' => config('qiscus.app_code'),
            'Qiscus-Secret-Key' => config('qiscus.secret_key'),
            'content-type' => 'application/json',
        ], json_encode([
            'to' => $phone_number,
            'type' => 'template',
            'template' => [
                'namespace' => '83d18f2e_6a34_4c56_b192_cc262c3b7ebc',
                'name' => $template_name,
                'language' => [
                    'policy' => 'deterministic',
                    'code' => 'id',
                ],
                'components' => $components,
            ],
        ]));
        $response = (new GuzzleClient())->sendRequest($request);

        // handling response
        $response_body = json_decode($response->getBody()->getContents());
        $log->new()->properties($response_body)->save('response body');

        $response_status = $response->getStatusCode();
        $log->new()->properties($response_status)->save('response status');

        if ($callback) {
            $callback($response_body);
        }

        return $response->getStatusCode() >= 200 && $response->getStatusCode() < 300;
    }

    public static function sendMultipleReceivers(
        $template_name,
        $parameters,
        $phone_numbers,
        $is_all_success = false,
        $components = null,
        $callback = false
    ) {
        $log = applog('erp, whatsapp__fac, send_multiple_receivers');
        $log->save('debug');

        $success = false;
        $all_success = true;

        collect($phone_numbers)->each(function ($phone_number) use (
            $template_name,
            $parameters,
            $components,
            &$success,
            &$all_success,
            $callback
        ) {
            if (static::send(
                $template_name,
                $parameters,
                $phone_number,
                $components,
                $callback
            )) {
                $success = true;
            } else {
                $all_success = false;
            }
        });

        if ($is_all_success) {
            return $all_success;
        }

        return $success;
    }
}

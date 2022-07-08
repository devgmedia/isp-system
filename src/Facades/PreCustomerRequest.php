<?php

namespace Gmedia\IspSystem\Facades;

use Gmedia\IspSystem\Models\Branch;
use Gmedia\IspSystem\Models\PreCustomerRequest as PreCustomerRequestModel;
use Gmedia\IspSystem\Models\PreCustomerRequestKnowFrom;
use Gmedia\IspSystem\Models\PreCustomerRequestNeed;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use GuzzleHttp\Client as GuzzleClient;

class PreCustomerRequest
{
    public static function sync($branch_name)
    {
        $log = applog('erp__pre_customer_request_fac');
        $log->save('sync');

        if (!Branch::where('name', $branch_name)->exists()) {
            return;
        }
        
        $provinces = [];
        if ($branch_name === 'Yogyakarta') {
            $provinces = array_merge($provinces, [34]);
        } else if ($branch_name === 'Bali') {
            $provinces = array_merge($provinces, [35, 51]);
        }

        $data = [];
        collect($provinces)->each(function ($province) use (&$data, $log) {
            $url = 'https://fiberstream.net.id/api/admin/list_pelanggan';

            $request = new GuzzleRequest('POST', $url, [
                'Content-Type' => 'application/json',
                'Client-Service' => 'front_end_client',
                'Auth-Key' => 'fiberstream',
                'Token' => 'FS62.UkPWZAqI4F0yx5CJHF7v8',
            ], json_encode([
                'coverage' => 0,
                'start' => 0,
                'limit' => 1000,
                'search' => null,
                'tgl_awal' => Carbon::now()->toDateString(),
                'tgl_akhir' => Carbon::now()->toDateString(),
                'provinsi' => $province,
                'kota' => null,
            ]));
            $response = (new GuzzleClient())->sendRequest($request);

            // handling response
            $response_body = json_decode($response->getBody()->getContents());
            $log->new()->properties($response_body)->save('response body');

            $data = array_merge($data, $response_body->response);
        });

        $branch_id = Branch::where('name', $branch_name)->value('id');

        collect($data)->map(function ($item) use ($branch_id) {
            $pre_customer_request = [
                'name' => ucfirst($item->nama),
                'email' => $item->email,
                'phone_number' => $item->nohp,
                'address' => ucfirst($item->alamat),
                'know_from_id' => PreCustomerRequestKnowFrom::where('name', 'Official Website')->value('id'),
                'need_id' => PreCustomerRequestNeed::where('name', 'Internet Rumah')->value('id'),
                'branch_id' => $branch_id,
            ];

            return $pre_customer_request;
        })->filter(function ($item) {
            $phone_number = $item['phone_number'];
            $email = $item['email'];

            $validator = Validator::make($item, [
                'name' => 'required|string|min:3|max:50|regex:/^[A-Z]{1}[A-Za-z()\-,.\/\s]+$/',
                'email' => [
                    'nullable',
                    'string',
                    'email:rfc',
                    function ($attribute, $value, $fail) use ($phone_number) {
                        if (!$phone_number && !$value) $fail('A email is required.');
                    },
                ],
                'phone_number' => [
                    'nullable',
                    'string',
                    'regex:/^[0-9+()]{1}[0-9+()\s]{1,18}[0-9+()]{1}$/',
                    function ($attribute, $value, $fail) use ($email) {
                        if (!$email && !$value) $fail('A phone number is required.');
                    },
                ],
                'address' => 'nullable|string|regex:/^[A-Z]{1}[0-9A-Za-z()\-,.\/\s]+$/',
                'know_from_id'=> 'nullable|exists: Gmedia\IspSystem\Models\PreCustomerRequestKnowFrom,id',
                'need_id'=> 'nullable|exists: Gmedia\IspSystem\Models\PreCustomerRequestNeed,id',
                'branch_id' => 'required|exists: Gmedia\IspSystem\Models\Branch,id',
            ]);

            return (!$validator->fails());
        })->each(function ($item) {
            PreCustomerRequestModel::create($item);
        });
    }
}

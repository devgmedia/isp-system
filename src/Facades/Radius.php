<?php

namespace Gmedia\IspSystem\Facades;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Radius
{
    public static function createUser($username, $password)
    {
        $log = applog('erp, radius__fac, create_user');
        $log->new()->properties($username)->save('username');

        if (! DB::connection('radius')->table('userinfo')->where('username', $username)->exists()) {
            $log->save('add userinfo');

            DB::connection('radius')->table('userinfo')->insert([
                'username' => $username,
                'changeuserinfo' => '0',
                'enableportallogin' => 0,
                'creationdate' => Carbon::now()->toDateTimeString(),
                'creationby' => 'administrator',
                'updatedate' => Carbon::now()->toDateTimeString(),
                'updateby' => 'administrator',
            ]);
        } else {
            $log->save('userinfo is exists');
        }

        if (! DB::connection('radius')->table('userbillinfo')->where('username', $username)->exists()) {
            $log->save('add userbillinfo');

            DB::connection('radius')->table('userbillinfo')->insert([
                'username' => $username,
                'changeuserbillinfo' => '0',
                'nextinvoicedue' => 0,
                'billdue' => 0,
                'creationdate' => Carbon::now()->toDateTimeString(),
                'creationby' => 'administrator',
                'updatedate' => Carbon::now()->toDateTimeString(),
                'updateby' => 'administrator',
                'lastbill' => Carbon::now()->toDateString(),
                'nextbill' => Carbon::now()->toDateString(),
            ]);
        } else {
            $log->save('userbillinginfo is exists');
        }

        if (! DB::connection('radius')->table('radcheck')->where('username', $username)->exists()) {
            $log->save('add radcheck');

            DB::connection('radius')->table('radcheck')->insert([
                'username' => $username,
                'attribute' => 'Cleartext-Password',
                'op' => ':=',
                'value' => $password,
            ]);
        } else {
            $log->save('radcheck is exists');
        }
    }

    public static function deleteUser($username)
    {
        $log = applog('erp, radius__fac, delete_user');

        // userinfo
        $userinfo = DB::connection('radius')->table('userinfo')
            ->where('username', $username)
            ->first();

        $log->new()->properties($userinfo)->save('userinfo data');

        DB::connection('radius')->table('userinfo')
            ->where('username', $username)
            ->delete();

        // userbillinfo
        $userbillinfo = DB::connection('radius')->table('userbillinfo')
            ->where('username', $username)
            ->first();

        $log->new()->properties($userbillinfo)->save('userbillinfo data');

        DB::connection('radius')->table('userbillinfo')
            ->where('username', $username)
            ->delete();

        // radcheck
        $radcheck = DB::connection('radius')->table('radcheck')
            ->where('username', $username)
            ->first();

        $log->new()->properties($radcheck)->save('radcheck data');

        DB::connection('radius')->table('radcheck')
            ->where('username', $username)
            ->delete();
    }
}

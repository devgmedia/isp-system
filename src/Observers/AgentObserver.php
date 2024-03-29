<?php

namespace Gmedia\IspSystem\Observers;

use app\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Gmedia\IspSystem\Models\Agent;
use Gmedia\IspSystem\Models\ProductBrand;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Models\Role;

class AgentObserver
{
    public function creating(Agent $agent)
    {
        // registration_date
        $agent->registration_date = Carbon::now()->toDateString();

        // uuid
        if (! $agent->uuid) {
            $uuid = null;

            do {
                $uuid = Uuid::uuid4();
            } while (Agent::where('uuid', $uuid)->exists());

            $agent->uuid = $uuid;
        }

        // user_id
        if (! $agent->user_id) {
            $password = Faker::create()->regexify('[A-Za-z0-9]{8}');
            $brand = ProductBrand::find($agent->brand_id);
            if ($brand) {
                $password = Hash::make($brand->agent_account_default_password);
            }

            $user = User::create([
                'name' => 'agent_'.$uuid,
                'email' => $agent->email,
                // 'password' => Hash::make($password),
                'password' => $password,
                'api_token' => Str::random(80),
            ]);
            $role = Role::where('name', 'agent')->get();
            $user->assignRole($role);

            $agent->user_id = $user->id;
            // send password to agent email
        }
    }

    /**
     * Handle the agent "created" event.
     *
     * @return void
     */
    public function created(Agent $agent)
    {
        //
    }

    /**
     * Handle the agent "updated" event.
     *
     * @return void
     */
    public function updated(Agent $agent)
    {
        //
    }

    /**
     * Handle the agent "deleted" event.
     *
     * @return void
     */
    public function deleted(Agent $agent)
    {
        //
    }

    /**
     * Handle the agent "restored" event.
     *
     * @return void
     */
    public function restored(Agent $agent)
    {
        //
    }

    /**
     * Handle the agent "force deleted" event.
     *
     * @return void
     */
    public function forceDeleted(Agent $agent)
    {
        //
    }
}

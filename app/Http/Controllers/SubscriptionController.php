<?php

namespace App\Http\Controllers;

use App\User;
use App\Droplet;
use App\Http\Requests\UserSubscriptionRequest;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function subscribe(UserSubscriptionRequest $request)
    {
        $email = $request->input('email');
        $user = User::where('email', '=', $email)->firstOrFail();

        if ($user->subscribed('Platonics Primary')) {
            // user already has a subscription, we just need to increment the quantity
            $subscription = $user->subscription('Platonics Primary')->incrementQuantity();
        } else {
            // user does not have subscription, we need to create a new one
            $stripeToken = $request->input('stripeToken');

            $subscription = $user->newSubscription('Platonics Primary', 'plan_ChGcTVhVwwvsLn')
                                ->create($stripeToken, ['email' => $email]);
        }

        $hostname = str_random(32);

        $droplet = Droplet::provision($hostname);

        Droplet::create([
            'do_id' => $droplet->id,
            'memory' => $droplet->memory,
            'vcpus' => $droplet->vcpus,
            'disk' => $droplet->disk,
            'region' => $droplet->region->slug,
            'backup_enabled' => $droplet->backupsEnabled,
            'user_id' => $user->id,
            'subscription_id' => $subscription->id,
            'name' => $request->input('blogName'),
            'desc' => $request->input('blogDesc'),
            'hostname' => $hostname
        ]);

        return redirect(route('home'));
    }
}

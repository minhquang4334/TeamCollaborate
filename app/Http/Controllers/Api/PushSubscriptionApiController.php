<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PushSubscriptionApiController extends ApiController
{
    use ValidatesRequests;
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Update user's subscription.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request)
    {
        $this->validate($request, ['endpoint' => 'required']);

        $request->user()->updatePushSubscription(
            $request->endpoint,
            $request->key,
            $request->token
        );

        return response()->json(['message' => 'ok'], 204);
    }

    /**
     * Delete the specified subscription.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request, ['endpoint' => 'required']);

        $request->user()->deletePushSubscription($request->endpoint);

        return response()->json(['message' => 'ok'], 204);
    }
}

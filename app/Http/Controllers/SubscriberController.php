<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class SubscriberController extends Controller
{

    /**
     * Used for subscribing to a topic
     *
     * @param Request $request
     * @param $topic
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribeToTopic(Request $request, $topic)
    {
        try {
            $redis = Redis::connection();

            $redis->rpush($topic, $request->url);

            return response()
                ->json([
                    'url' => $request->url,
                    'topic' => $topic
                ], 200);

        } catch (\Exception $e) {
            return response()
                ->json([
                    'status' => false,
                    'msg' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ], 500);
        }
    }

    public function receiveData(Request $request)
    {
        try {

            Log::info(json_encode($request->all(), JSON_PRETTY_PRINT));

        } catch (\Exception $e) {
            return response()
                ->json([
                    'status' => false,
                    'msg' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ], 500);
        }
    }

    public function getAllSubscribers($topic)
    {

        try {
            $redis = Redis::connection();

            $urls = $redis->lrange($topic, 0, -1);

            return response()
                ->json([
                    'status' => true,
                    'data' => $urls
                ], 200);

        } catch (\Exception $e) {
            return response()
                ->json([
                    'status' => false,
                    'msg' => $e->getMessage(),
                    'trace' => $e->getTrace()
                ], 500);
        }
    }

}

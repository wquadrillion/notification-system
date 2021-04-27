<?php

namespace App\Http\Controllers;

use App\Jobs\Publish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class PublisherController extends Controller
{

    /**
     * Used for publishing to a topic
     *
     * @param Request $request
     * @param $topic
     * @return \Illuminate\Http\JsonResponse
     */
    public function publishToTopic(Request $request, $topic)
    {
        try {
            $redis = Redis::connection();

            $urls = $redis->lrange($topic, 0, -1);
            $url_num = count($urls);
            $data = $request->all();

            Publish::dispatch($topic, $data, $urls);

            return response()
                ->json([
                    'status' => true,
                    'msg' => "Published to $url_num url(s)"
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

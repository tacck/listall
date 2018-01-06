<?php

namespace App\Http\Controllers;

use App\Http\Service\ApiBookmarkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;

class ApiBookmarkController extends Controller
{

    /**
     * @param Request $request
     * @return string
     */
    public function commit(Request $request)
    {
        if (!ApiBookmarkService::isCollectKey($request->input("key"))) {
            Log::info("incorrect key:" . $request->input("key"));
            return "{'status': 403}";
        }

        $params = $request->all();
        $status = 200;

        try {
            if (!ApiBookmarkService::commitBookmark(
                $params['username'],
                $params['title'],
                $params['url'],
                $params['permalink'],
                $params['comment'],
                $params['is_private'],
                $params['timestamp']
            )) {
                $status = 500;
            }
        } catch (\Exception $e) {
            $status = 500;
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }


        return "{'status': $status}";
    }
}

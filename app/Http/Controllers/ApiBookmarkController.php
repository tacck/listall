<?php

namespace App\Http\Controllers;

use App\Http\Service\ApiBookmarkService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
            return  response('incorrect key', Response::HTTP_FORBIDDEN);
        }

        $params = $request->all();
        $status = Response::HTTP_CREATED;
        $message = "created";

        try {
            if (!ApiBookmarkService::commitBookmark(
                $params['username'],
                $params['title'],
                $params['url'],
                $params['permalink'],
                $params['comment'],
                $params['is_private'],
                $params['timestamp'],
                $params['status']
            )) {
                $status = Response::HTTP_INTERNAL_SERVER_ERROR;
                $message = "internal server error";
            }
        } catch (\Exception $e) {
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $message = "internal server error";
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }

        return  response($message, $status);
    }
}

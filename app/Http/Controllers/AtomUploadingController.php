<?php

namespace App\Http\Controllers;

use App\Http\Service\AtomUploadingService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AtomUploadingController extends Controller
{
    /**
     * GET '/atomUploading'
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('atomUploading.index');
    }

    /**
     * POST '/atomUploading'
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        try {
            if ($request->hasFile('atomFile')) {
                $file = $request->file('atomFile');
                AtomUploadingService::storeAtomEntries($file->path());
            }
        } catch (QueryException $e) {
            // TODO: エラーを画面へ表示
            $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            $message = "internal server error";
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());
        }

        // 登録ページへリダイレクト
        return view('atomUploading.index');
    }
}

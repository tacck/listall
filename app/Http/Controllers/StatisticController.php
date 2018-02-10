<?php

namespace App\Http\Controllers;


use App\Http\Service\BookmarkService;
use Illuminate\Http\Request;

class StatisticController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        // TODO: 集計ページトップ

        $page = isset($request->page) ? $request->page : 1;
        $bookmarks = BookmarkService::getCountEachDaysWithoutReadForLater(
            "2018-01-01",
            (new \DateTime())->format("Y-m-d"),
            $page,
            10
        );

        // ページネーションのパス設定
        $bookmarks->withPath($request->url());

        return view('statistics.index', compact('bookmarks'));
    }
}
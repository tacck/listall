<?php

namespace App\Http\Controllers;


use App\Http\Service\BookmarkService;

class StatisticController extends Controller
{

    public function index()
    {
        // TODO: 集計ページトップ
        $bookmarks = BookmarkService::getCountEachDaysWithoutReadForLater(
            "2018-01-01",
            (new \DateTime())->format("Y-m-d")
        );

        return view('statistics.index', compact('bookmarks'));
    }
}
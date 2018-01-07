<?php

namespace App\Http\Service;

use App\Bookmark;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookmarkService
{

    /**
     * @return array
     */
    public static function getAll()
    {
        return Bookmark::where('user_id', Auth::id())
            ->orderBy('id', 'asc')
            ->get()
            ->toArray();
    }

    /**
     * @param $id
     * @return mixed
     */
    public static function getById($id)
    {
        return Bookmark::find($id);
    }

    /**
     * 日別ブックマーク数集計
     *
     * @param $beginDate
     * @param $endDate
     * @return mixed
     */
    public static function getCountEachDays($beginDate, $endDate)
    {
        $bookmarks = Bookmark::where('user_id', Auth::id())
            ->where('htn_add_date', '>=', $beginDate)
            ->where('htn_add_date', '<=', $endDate)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get(
                [DB::raw("htn_add_date as date, count(htn_add_date) as count")]
            )
            ->toArray();

        return $bookmarks;
    }

    public static function getCountEachDaysWithoutReadForLater($beginDate, $endDate)
    {
        $bookmarks = Bookmark::where('user_id', Auth::id())
            ->where('htn_add_date', '>=', $beginDate)
            ->where('htn_add_date', '<=', $endDate)
            ->where('is_read_for_later', '=', 0)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get(
                [DB::raw("htn_add_date as date, count(htn_add_date) as count")]
            )
            ->toArray();

        return $bookmarks;
    }

    public static function getCountEachDaysOnlyReadForLater($beginDate, $endDate)
    {
        $bookmarks = Bookmark::where('user_id', Auth::id())
            ->where('htn_add_date', '>=', $beginDate)
            ->where('htn_add_date', '<=', $endDate)
            ->where('is_read_for_later', '=', 1)
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get(
                [DB::raw("htn_add_date as date, count(htn_add_date) as count")]
            )
            ->toArray();

        return $bookmarks;
    }
}
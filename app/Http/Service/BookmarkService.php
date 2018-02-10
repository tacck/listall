<?php

namespace App\Http\Service;

use App\Bookmark;
use Illuminate\Pagination\LengthAwarePaginator;
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

    /**
     * @param string $beginDate
     * @param string $endDate
     * @param int $page
     * @param int $size
     * @return LengthAwarePaginator
     */
    public static function getCountEachDaysWithoutReadForLater(string $beginDate, string $endDate, int $page, int $size)
    {
        if ($page < 1) {
            throw new \InvalidArgumentException("page should be larger than 0.");
        }
        if ($size < 1) {
            throw new \InvalidArgumentException("size should be larger than 0.");
        }

        $bookmarks = Bookmark::where('user_id', Auth::id())
            ->where('htn_add_date', '>=', $beginDate)
            ->where('htn_add_date', '<=', $endDate)
            ->where('is_read_for_later', '=', 0)
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get(
                [DB::raw("htn_add_date as date, count(htn_add_date) as count")]
            )
            ->toArray();

        // 一覧をページネーション対応
        $paginator = new LengthAwarePaginator(
            array_slice($bookmarks, ($page - 1) * $size, $size),
            count($bookmarks),
            $size);

        return $paginator;
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
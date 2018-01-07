<?php

namespace App\Http\Service;


use App\Bookmark;
use App\User;
use Illuminate\Support\Facades\Log;

class ApiBookmarkService
{
    /**
     *
     * @param string $key
     * @return bool
     */
    public static function isCollectKey($key)
    {
        Log::info("key:" . $key);
        Log::info("env_key:" . env('HATENA_BOOKMARK_WEBHOOK_KEY', ''));
        return !is_null($key) && $key !== "" && env("HATENA_BOOKMARK_WEBHOOK_KEY", "") === $key;
    }

    /**
     * @param string $username
     * @param string $title
     * @param string $url
     * @param string $permalink
     * @param string $comment
     * @param string $is_private
     * @param string $timestamp
     * @return bool
     */
    public static function commitBookmark($username, $title, $url, $permalink, $comment, $is_private, $timestamp)
    {
        $htnUser = User::where('htn_name', $username)->first();

        // TODO: 削除対応 sateを見る必要ありそう

        $bookmark = null;
        $addedBookmark = Bookmark::where('permalink', $permalink)->first();
        if ($addedBookmark) {
            Log::debug("updated");
            $bookmark = $addedBookmark;
            $bookmark->setAttribute("updated_at", (new \DateTime())->format("Y-m-d H:i:s"));
        } else {
            $bookmark = new Bookmark();
        }

        $is_read_for_later = preg_match('/' . env('HATENA_BOOKMARK_READ_FOR_LATER_TAG') .'/', $comment);
        Log::debug('/' . env('HATENA_BOOKMARK_READ_FOR_LATER_TAG') .'/:' . $comment);

        $bookmark->setAttribute("username", $username);
        $bookmark->setAttribute("title", $title);
        $bookmark->setAttribute("url", $url);
        $bookmark->setAttribute("permalink", $permalink);
        $bookmark->setAttribute("comment", $comment);
        $bookmark->setAttribute("is_private", $is_private);
        $bookmark->setAttribute("is_read_for_later", $is_read_for_later); // 0:読了 1:後で読む
        $bookmark->setAttribute("htn_add_datetime", (new \DateTime($timestamp))->format("Y-m-d H:i:s"));
        $bookmark->setAttribute("htn_add_date", (new \DateTime($timestamp))->format("Y-m-d")); // 日毎集計用
        $bookmark->setAttribute("user_id", $htnUser->id);

        return $bookmark->save();
    }
}
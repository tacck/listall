<?php

namespace App\Http\Service;

use App\Bookmark;
use App\User;
use Carbon\Carbon;
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
        // TODO: ユーザー名とキーの組み合わせでチェックするようにする
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
     * @param string $status
     * @return bool
     */
    public static function commitBookmark($username, $title, $url, $permalink, $comment, $is_private, $timestamp, $status)
    {
        // TODO: 削除対応 $statusをチェック

        $arr = self::toArray($username, $title, $url, $permalink, $comment, $is_private, $timestamp);
        if (count($arr) == 0) {
            return false;
        }

        $bookmark = null;
        $addedBookmark = Bookmark::where('permalink', $permalink)->first();
        if ($addedBookmark) {
            Log::debug("updated");
            $bookmark = $addedBookmark;
            $bookmark->setAttribute("updated_at", $arr['updated_at']);
        } else {
            $bookmark = new Bookmark();
        }

        $bookmark->setAttribute("username", $arr['username']);
        $bookmark->setAttribute("title", $arr['title']);
        $bookmark->setAttribute("url", $arr['url']);
        $bookmark->setAttribute("permalink", $arr['permalink']);
        $bookmark->setAttribute("comment", $arr['comment']);
        $bookmark->setAttribute("is_private", $arr['is_private']);
        $bookmark->setAttribute("is_read_for_later", $arr['is_read_for_later']);
        $bookmark->setAttribute("htn_add_datetime", $arr['htn_add_datetime']);
        $bookmark->setAttribute("htn_add_date", $arr['htn_add_date']);
        $bookmark->setAttribute("user_id", $arr['user_id']);

        return $bookmark->save();
    }

    /**
     * @param string $username
     * @param string $title
     * @param string $url
     * @param string $permalink
     * @param string $comment
     * @param string $is_private
     * @param string $timestamp
     * @return array
     */
    public static function toArray($username, $title, $url, $permalink, $comment, $is_private, $timestamp)
    {
        $arr = [];

        $htnUser = User::where('name', $username)->first();
        if (is_null($htnUser)) {
            return $arr;
        }

        $now = Carbon::now()->format("Y-m-d H:i:s");
        $htnAddTime = Carbon::createFromFormat(DATE_W3C, $timestamp);

        $is_read_for_later = preg_match('/' . env('HATENA_BOOKMARK_READ_FOR_LATER_TAG') . '/', $comment);
        Log::debug('/' . env('HATENA_BOOKMARK_READ_FOR_LATER_TAG') . '/:' . $comment);

        $arr['username'] = $username;
        $arr['title'] = $title;
        $arr['url'] = $url;
        $arr['permalink'] = $permalink;
        $arr['comment'] = $comment;
        $arr['is_private'] = $is_private;
        $arr['is_read_for_later'] = $is_read_for_later; // 0:読了 1:後で読む
        $arr['htn_add_datetime'] = $htnAddTime->format("Y-m-d H:i:s");
        $arr['htn_add_date'] = $htnAddTime->format("Y-m-d"); // 日毎集計用
        $arr['user_id'] = $htnUser->id;
        $arr['created_at'] = $now;
        $arr['updated_at'] = $now;

        return $arr;
    }
}
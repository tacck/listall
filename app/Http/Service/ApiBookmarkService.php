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

        // TODO: 更新対応 (後で読むタグ付きから、タグを無くした状態)
        $bookmark = null;
        $addedBookmark = Bookmark::where('permalink', $permalink)->first();
        if ($addedBookmark) {
            Log::debug("added");
            $bookmark = $addedBookmark;
            $bookmark->setAttribute("updated_at", (new \DateTime())->format("Y-m-d H:i:s"));
        } else {
            $bookmark = new Bookmark();
        }

        $bookmark->setAttribute("username", $username);
        $bookmark->setAttribute("title", $title);
        $bookmark->setAttribute("url", $url);
        $bookmark->setAttribute("permalink", $permalink);
        $bookmark->setAttribute("comment", $comment);
        $bookmark->setAttribute("is_private", $is_private);
        $bookmark->setAttribute("htn_add_datetime", (new \DateTime($timestamp))->format("Y-m-d H:i:s"));
        $bookmark->setAttribute("user_id", $htnUser->id);

        return $bookmark->save();
    }
}
<?php

namespace App\Http\Service;

use App\Bookmark;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AtomUploadingService
{
    /**
     * @param string $path
     * @return bool
     */
    public static function storeAtomEntries($path)
    {
        $feed = \Feeds::make($path);
        $items = $feed->get_items();

        $entries = [];

        foreach ($items as $item) {
            $c = $item->get_categories();
            $categories = '';
            if ($c && count($c) > 0) {
                foreach ($c as $category) {
                    $categories .= '[' . $category->get_label() . ']';
                }
            }

            $arr = ApiBookmarkService::toArray(
                $item->get_author()->get_name(),
                $item->get_title(),
                $item->get_link(0, 'related'),
                $item->get_permalink(),
                $categories . $item->get_description(),
                1,
                $item->get_date(DATE_W3C)
            );

            array_push($entries, $arr);
        }

        return Bookmark::blkInsert($entries, true);
    }
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Bookmark extends Model
{
    /**
     * @param array $items
     * @param bool $doTruncate
     * @return bool
     * @throws QueryException
     */
    public static function blkInsert($items, $doTruncate = false) {
        if (empty($items)) {
            return false;
        }

        $db = \DB::table('bookmarks');

        if ($doTruncate) {
            $db->truncate();
        }

        return $db->insert($items);
    }
}

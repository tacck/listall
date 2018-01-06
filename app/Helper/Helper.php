<?php
namespace App\Helper;

class Helper
{

    /**
     * @param $path
     * @return string
     */
    public static function assetEx($path)
    {
        if (app()->isLocal()) {
            return asset($path);
        } else {
            return secure_asset($path);
        }
    }
}
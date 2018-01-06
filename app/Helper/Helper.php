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

    public static function routeEx($name, $parameters = [], $absolute = true)
    {
        if (app()->isLocal()) {
            return route($name, $parameters, $absolute);
        } else {
            return app('url')->secure($name, $parameters, $absolute);
        }

    }
}
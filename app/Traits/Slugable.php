<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 29.04.2020
 * Time: 12:21
 */

namespace App\Traits;

use Illuminate\Support\Str;

trait Slugable
{
    /**
     * @param $name
     * @return string
     */
    public static function getSlug($name)
    {
        $slug = Str::slug($name);
        $rows  = self::whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'")->withTrashed()->get();
        $count = count($rows) + 1;
        return ($count > 1) ? "{$slug}-{$count}" : $slug;
    }
}
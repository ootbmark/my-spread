<?php

const PER_PAGE = 20;

/**
 * @param $type
 * @return int|mixed
 */
function m_per_page($type = 'per_page')
{
    if (session()->has($type)) {
        return session()->get($type);
    }
    return PER_PAGE;
}

/**
 * @param $value
 * @param $field
 * @param $array
 * @return bool
 */
function in_array_field($value, $field, $array) {
    foreach($array as $val){
        if($val[$field] == $value) {
            return true;
        }
    }
    return false;
}

/**
 * @param $html
 * @param null $skip
 * @return string|string[]|null
 */
function m_nofollow($html, $skip = null) {
    return preg_replace_callback(
        "#(<a[^>]+?)>#is", function ($mach) use ($skip) {
        return (
            !($skip && strpos($mach[1], $skip) !== false) &&
            strpos($mach[1], 'rel=') === false
        ) ? $mach[1] . ' rel="nofollow">' : $mach[0];
    },
        $html
    );
}




<?php

use Illuminate\Support\Str;

if (!function_exists("getLastCharacter")) {

    /**
     * Get the last character on a string.
     *
     * @param string $string
     * @return string
     */
    function getLastCharacter(string $string)
    {
        return Str::substr($string, -1, 1);
    }
}

if (!function_exists("getCountFromExpression")) {

    /**
     * Get the count from Expression.
     *
     * @param string $string
     * @return mixed
     */
    function getCountFromExpression(string $string)
    {
        $firstChar = Str::substr($string, 0, strlen($string) - 1);
        $result = is_numeric($firstChar) ? $firstChar :  1;
        return (float) $result;
    }
}

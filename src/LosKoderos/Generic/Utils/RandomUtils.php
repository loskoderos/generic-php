<?php

namespace LosKoderos\Generic\Utils;

class RandomUtils
{
    const DEFAULT_DICT = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    public static function randomString(int $n, $dict = null): string
    {
        $dict = isset($dict) ? $dict : self::DEFAULT_DICT;
        $m = is_string($dict) ? strlen($dict) : count($dict);
        $s = '';
        $n++;
        while (--$n) {
            $s .= $dict[rand(0, $m - 1)];
        }
        return $s;
    }
}

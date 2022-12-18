<?php

namespace Koderos\Generic\Utils;

class RandomUtils
{
    const DEFAULT_DICT = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    public static function randomString(int $n, ?array $dict = null): string
    {
        $dict = is_array($dict) ? $dict : self::DEFAULT_DICT;
        $m = strlen($dict);
        $s = '';
        $n++;
        while (--$n) {
            $s .= $dict[rand(0, $m - 1)];
        }
        return $s;
    }
}

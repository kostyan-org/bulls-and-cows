<?php

namespace KostyanOrg\BullsAndCows;

final class Lang
{
    const EN = 1;
    const RU = 2;

    private static $currentLang = self::EN;

    final public static function set(int $str): void
    {
        self::$currentLang = $str;
    }

    final public static function get(string $str): string
    {
        $dictionary = (array)require "Dictionary.php";

        if (self::getCurrentLang() === self::RU && isset($dictionary[$str][self::RU])) {
            return $dictionary[$str][self::RU];
        }

        return $str;
    }

    final public static function getCurrentLang(): int
    {
        return (int)self::$currentLang;
    }
}

<?php

namespace KostyanOrg\BullsAndCows;

use ReflectionClass;

final class State
{
    const EXIT = 0;
    const WELLCOME = 1;
    const START = 2;
    const RULES = 3;
    const EXCEPTION = 4;
    const START_MY = 5;
    const STOP = 6;
    const SELECT_LANG = 7;
    const GAME = 40;
    const GAME_UNIQ = 50;
    const GAME_MY = 55;
    const TRY = 60;
    const HELP = 61;
    const WINNER = 90;
    const TEST = 99;

    private static $state = self::WELLCOME;

    final public static function get(string $state): int
    {

        if (is_numeric($state) && self::toString($state)) {
            return (int)$state;
        }

        $refl = new ReflectionClass(__CLASS__);
        if (empty($refl->getConstant($state))) {
            throw new GameException(sprintf(Lang::get("Action on command [%s] does not exist! Use the menu\n"), $state));
        }

        return (int)constant(__CLASS__ . "::" . $state);
    }

    final public static function toString(int $stateInt): string
    {
        $refl = new ReflectionClass(__CLASS__);
        $constantsArr = $refl->getConstants();
        $name = array_search($stateInt, $constantsArr);

        if (empty($name)) {
            throw new GameException(sprintf(Lang::get("There is no action for command [%d]! Please use menu\n"), $stateInt));
        }
        return $name;
    }

    final public static function set(int $state): void
    {
        self::$state = self::get($state);
    }

    final public static function getCurrentState(): int
    {
        return (int)self::$state;
    }
}

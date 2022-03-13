<?php

namespace KostyanOrg\BullsAndCows;

final class Menu
{
    const STATES_FOR_MAIN_MENU = [
        State::RULES,
        State::WELLCOME,
        State::WINNER,
        State::STOP,
        State::EXCEPTION
    ];

    const STATES_FOR_TRY_MENU = [
        State::TRY,
        State::GAME,
        State::GAME_UNIQ,
        State::GAME_MY
    ];

    final public static function string(): string
    {
        $menu = [];

        if (self::needMenu(self::STATES_FOR_MAIN_MENU)) {
            $menu = [
                State::EXIT => Lang::get("exit"),
                State::RULES => Lang::get("rules"),
                State::WELLCOME => Lang::get("main")
            ];
            return self::getMenu($menu);

        } elseif (self::needMenu(self::STATES_FOR_TRY_MENU)) {
            $menu = ["!s" => Lang::get("stop the game")];
            return self::getMenu($menu);
        }

        return self::getMenu($menu);
    }

    final public static function getMenu(array $menuConstant): string
    {
        $menuString = "";

        foreach ($menuConstant as $key => $value) {
            $menuString .= sprintf(" [%s] %s", $key, $value);
        }

        $menuString = empty($menuString) ? ""
            : sprintf("\n----------\n%s:%s\n", Lang::get("menu"), $menuString);
        return $menuString;
    }

    final public static function needMenu(array $states): bool
    {
        return in_array(State::getCurrentState(), $states);
    }
}

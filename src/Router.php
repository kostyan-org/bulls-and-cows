<?php

namespace KostyanOrg\BullsAndCows;

final class Router
{
    const ROUTES = [

        State::WELLCOME => [
            State::WELLCOME,
            State::RULES,
            State::START,
            State::SELECT_LANG,
            State::EXIT,
            State::EXCEPTION
        ],

        State::SELECT_LANG => [
            State::WELLCOME,
            State::EXIT,
            State::EXCEPTION
        ],

        State::EXCEPTION => [
            State::EXCEPTION,
            State::RULES,
            State::WELLCOME,
            State::EXIT,

        ],

        State::RULES => [
            State::RULES,
            State::WELLCOME,
            State::EXIT,
            State::EXCEPTION,
        ],

        State::START => [
            State::GAME,
            State::GAME_UNIQ,
            State::START_MY
        ],

        State::START_MY => [
            State::START_MY,
            State::GAME_MY,
            State::EXIT,
            State::EXCEPTION,
        ],

        State::GAME => [
            State::TRY,
            State::EXIT,
            State::EXCEPTION,
        ],

        State::GAME_UNIQ => [
            State::TRY,
            State::EXIT,
            State::EXCEPTION,
        ],

        State::GAME_MY => [
            State::TRY,
            State::EXIT,
            State::EXCEPTION,
        ],

        State::TRY => [
            State::TRY,
            State::HELP,
            State::WINNER,
            State::STOP,
            State::EXIT,
            State::EXCEPTION,
        ],

        State::STOP => [
            State::STOP,
            State::WELLCOME,
            State::RULES,
            State::EXIT,
            State::EXCEPTION,
        ],

        State::HELP => [
            State::TRY,
            State::EXIT,
            State::EXCEPTION,
        ],

        State::WINNER => [
            State::WINNER,
            State::RULES,
            State::WELLCOME,
            State::EXIT,
            State::EXCEPTION,
        ],
    ];

    final public static function go(int $state): void
    {
        if (!self::hasNext($state)) {
            throw new GameException(
                sprintf(
                    Lang::get("Switching from [%d] %s to [%d] %s is forbidden!\n"),
                    State::getCurrentState(),
                    State::toString(State::getCurrentState()),
                    $state,
                    State::toString($state)
                ),
            );
        }

        State::set($state);
    }

    final public static function hasNext(int $state): bool
    {
        $stateCurrent = State::getCurrentState();
        $stateNext = State::get($state);

        if (!isset(self::ROUTES[$stateCurrent])) {
            throw new GameException(
                sprintf(
                    Lang::get("No route from [%s]\n"),
                    State::toString($stateCurrent)
                )
            );
        }

        return in_array($stateNext, self::ROUTES[$stateCurrent]);
    }
}

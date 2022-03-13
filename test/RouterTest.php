<?php

namespace test;

use KostyanOrg\BullsAndCows\GameException;
use KostyanOrg\BullsAndCows\Router;
use KostyanOrg\BullsAndCows\State;
use Exception;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testRoutes()
    {
        $this->assertNotEmpty(Router::ROUTES);
        $this->assertIsArray(Router::ROUTES);
    }

    public function testGo()
    {

        State::set(State::WELLCOME);
        $this->assertEmpty(Router::go(State::WELLCOME));

        State::set(State::WELLCOME);
        try {
            Router::go(State::WINNER);
            throw new Exception("shouldn't have been here");
        } catch (GameException $e) {
            $this->assertInstanceOf(GameException::class, $e);
        }
    }

    public function testHasNext()
    {
        State::set(State::WELLCOME);

        $this->assertIsBool(Router::hasNext(State::EXIT));
        $this->assertFalse(Router::hasNext(State::WINNER));

        State::set(State::TEST);
        try {
            Router::hasNext(State::EXIT);
            throw new Exception("shouldn't have been here");
        } catch (GameException $e) {
            $this->assertInstanceOf(GameException::class, $e);
        }
    }
}

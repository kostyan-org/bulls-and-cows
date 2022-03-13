<?php

namespace test;

use KostyanOrg\BullsAndCows\GameException;
use PHPUnit\Framework\TestCase;

class GameExceptionTest extends TestCase
{
    public function testException()
    {
        $this->assertInstanceOf(GameException::class, new GameException());
    }
}

<?php

namespace test;

use KostyanOrg\BullsAndCows\GameException;
use KostyanOrg\BullsAndCows\State;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class StateTest extends TestCase
{
    public function testTypeConstants()
    {
        $refl = new ReflectionClass(State::class);
        foreach ($refl->getConstants() as $v) {
            $this->assertIsInt($v);
        }
    }

    public function testState()
    {
        $this->assertClassHasStaticAttribute("state", State::class);
    }

    public function testGet()
    {
        $this->assertNotEmpty(State::get(1));
        $this->assertIsInt(State::get("WELLCOME"));
        $this->assertIsInt(State::get(1));
    }

    public function testToString()
    {
        $this->expectException(GameException::class);
        $this->expectExceptionMessageMatches("/\[500\]/s");
        State::toString(500);

        $this->assertIsString(State::toString(1));
        $this->assertEquals(State::toString(1), "WELLCOME");
    }

    public function testSet()
    {
        $this->assertEmpty(State::set(State::WELLCOME));
        State::set(State::WINNER);
        $this->assertEquals(State::getCurrentState(), State::WINNER);
    }

    public function testCurrentState()
    {
        $this->assertNotEmpty(State::getCurrentState());
        $this->assertIsInt(State::getCurrentState());
    }
}

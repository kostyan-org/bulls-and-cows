<?php

namespace test;

use PHPUnit\Framework\TestCase;
use KostyanOrg\BullsAndCows\Menu;
use KostyanOrg\BullsAndCows\State;

class MenuTest extends TestCase
{
    public function testString()
    {
        State::set(State::WELLCOME);
        $this->assertNotEmpty(Menu::string());
        $this->assertIsString(Menu::string());

        State::set(State::EXIT);
        $this->assertEmpty(Menu::string());
    }

    public function testGetMenu()
    {
        $this->assertEmpty(Menu::getMenu([]));
        $this->assertIsString(Menu::getMenu([]));

        $menu = ["!s" => "stop the game"];
        $this->assertNotEmpty(Menu::getMenu($menu));
    }

    public function testNeedMenu()
    {
        State::set(State::TRY);
        $this->assertTrue(Menu::needMenu(Menu::STATES_FOR_TRY_MENU));
        State::set(State::EXIT);
        $this->assertFalse(Menu::needMenu(Menu::STATES_FOR_TRY_MENU));
    }
}

<?php

namespace test;

use KostyanOrg\BullsAndCows\Lang;
use PHPUnit\Framework\TestCase;

class LangTest extends TestCase
{
    public function testConstants()
    {
        $this->assertNotEmpty(Lang::EN);
        $this->assertNotEmpty(Lang::RU);
    }

    public function testCurrentLang()
    {
        $this->assertClassHasStaticAttribute("currentLang", Lang::class);
        $this->assertIsInt(Lang::getCurrentLang());
        $this->assertEquals(Lang::getCurrentLang(), Lang::EN);
    }

    public function testSet()
    {
        Lang::set(Lang::RU);
        $this->assertEquals(Lang::getCurrentLang(), Lang::RU);
        Lang::set(Lang::EN);
    }

    public function testGet()
    {
        Lang::set(Lang::RU);
        $this->assertEquals(Lang::get("test"), "тест");
        Lang::set(Lang::EN);
        $this->assertEquals(Lang::get("test"), "test");
    }
}

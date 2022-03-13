<?php

namespace test;

use KostyanOrg\BullsAndCows\Lang;
use PHPUnit\Framework\TestCase;

class DictionaryTest extends TestCase
{
    public function testDictionary()
    {
        $file = __DIR__ . "/../src/Dictionary.php";
        $test = "test";
        $this->assertFileIsReadable($file);
        $dict = require $file;
        $this->assertIsArray($dict);
        $this->assertArrayHasKey($test, $dict);
        $this->assertArrayHasKey(Lang::RU, $dict[$test]);
        $this->assertEquals($dict[$test][Lang::RU], "тест");
    }
}

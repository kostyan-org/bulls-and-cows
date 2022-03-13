<?php

namespace test;

use KostyanOrg\BullsAndCows\Game;
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase
{
    public function testStatic()
    {
        $this->assertClassHasStaticAttribute("lastOut", Game::class);
        $this->assertClassHasStaticAttribute("lastInput", Game::class);
        $this->assertClassHasStaticAttribute("hiddenNumber", Game::class);
        $this->assertClassHasStaticAttribute("exceptionMessage", Game::class);
        $this->assertClassHasStaticAttribute("debug", Game::class);
        $this->assertClassHasStaticAttribute("history", Game::class);
        $this->assertClassHasStaticAttribute("title", Game::class);
    }

    public function testConstruct()
    {
        $game = new Game();
        $this->assertInstanceOf(Game::class, $game);
    }

    public function testTitle()
    {
        $game = new Game();
        $game->setTitle("test");
        $title = $game->getTitle();
        $this->assertStringContainsString("test", $title);
        $title = $game->getTitle();
        $this->assertEmpty($title);
    }

    public function testDebug()
    {
        $game = new Game(true);
        $this->assertTrue($game->isDebug());
        $game = new Game();
        $this->assertFalse($game->isDebug());
    }

    public function testLastOut()
    {
        $game = new Game();
        $test = "test";
        $game->setLastOut($test);
        $this->assertEquals($game->getLastOut(), $test);
    }

    public function testHistory()
    {
        $game = new Game();
        $test = "test";
        $game->setHistory($test);
        $this->assertIsArray($game->getHistory());
        $this->assertEquals($game->getHistory()[0], $test);
        $this->assertEquals($game->getHistoryString(), $test);
        $game->resetHistory();
        $this->assertEmpty($game->getHistory());
        $this->assertEmpty($game->getHistoryString());

        for ($i = 0; $i < 10; $i++) {
            $game->setHistory($test);
        }

        $this->assertCount(10, $game->getHistory());
        $this->assertEquals(substr_count($game->getHistoryString(5), $test), 5);
    }

    public function testLastInput()
    {
        $game = new Game();
        $test = "test";
        $game->setLastInput($test);
        $this->assertEquals($game->getLastInput(), $test);
    }

    public function testOut()
    {
        $game = new Game();
        $testTitle = "testTitle";
        $test = "test";
        $game->setLastOut("");
        $game->setTitle($testTitle);
        $game->out($test);
        $getPrint = $this->getActualOutput();
        ob_clean();

        $this->assertStringContainsString($testTitle, $getPrint);
        $this->assertStringContainsString($test, $getPrint);
        $this->assertEquals($game->getLastOut(), $getPrint);

        $game = new Game(true); // debug mode
        $game->setLastOut("");
        $game->setTitle($testTitle);
        $game->out($test);
        $getPrint = $this->getActualOutput();
        ob_clean();

        $this->assertStringContainsString($testTitle, $getPrint);
        $this->assertStringContainsString($test, $getPrint);
        $this->assertStringContainsString("State", $getPrint);
        $this->assertEquals($game->getLastOut(), $getPrint);
    }

    public function testCleanUp()
    {
        $game = new Game();
        $test = "test";
        $game->cleanUp($test);
        $getPrint = $this->getActualOutput();
        ob_clean();
        $str = str_repeat(" ", mb_strlen($test));
        $this->assertEquals($getPrint, "\X1B[A\r" . $str . "\r");
    }

    public function testHiddenNumber()
    {
        $game = new Game();
        $testSmall = "01";
        $testBig = "0123456789";
        $game->setHiddenNumber();
        $hidden = $game->getHiddenNumber();

        $this->assertNotEmpty($hidden);
        $this->assertIsString($hidden);
        $this->assertEquals(mb_strlen($hidden), 4);

        // ------
        for ($i = 0; $i < 10; $i++) {

            $game->setHiddenNumber(true); // unique
            $hidden = $game->getHiddenNumber();
            $uniqHidden = implode("", array_unique(mb_str_split($hidden)));

            $this->assertNotEmpty($hidden);
            $this->assertIsString($hidden);
            $this->assertEquals(mb_strlen($hidden), 4);
            $this->assertEquals($uniqHidden, $hidden);
        }

        // ------
        $result = $game->setHiddenNumberMy($testSmall);
        $hidden = $game->getHiddenNumber();
        $this->assertTrue($result);
        $this->assertEquals($hidden, $testSmall);

        $result = $game->setHiddenNumberMy($testBig);
        $hidden = $game->getHiddenNumber();
        $this->assertFalse($result);
        $this->assertEmpty($hidden);
    }

    public function testCheckCondition()
    {
        $game = new Game();
        $sourceString  = "4567";

        $searchString1 = "0123";
        $searchString2 = "4500";
        $searchString3 = "0045";
        $searchString4 = "4567";
        $searchString5 = "452";
        $searchString6 = "456712";

        // 1
        $arr = $game->checkCondition($searchString1, $sourceString);
        $this->assertIsArray($arr);
        $this->assertNull($arr["error"]);
        $this->assertEquals($arr["searchString"], $searchString1);
        $this->assertEquals($arr["sourceString"], $sourceString);
        $this->assertFalse($arr["found"]);
        $this->assertEquals($arr["foundСounter"], 0);
        $this->assertEquals($arr["foundPositions"], 0);

        // 2
        $arr = $game->checkCondition($searchString2, $sourceString);
        $this->assertIsArray($arr);
        $this->assertNull($arr["error"]);
        $this->assertEquals($arr["searchString"], $searchString2);
        $this->assertEquals($arr["sourceString"], $sourceString);
        $this->assertTrue($arr["found"]);
        $this->assertEquals($arr["foundСounter"], 2);
        $this->assertEquals($arr["foundPositions"], 2);

        // 3
        $arr = $game->checkCondition($searchString3, $sourceString);
        $this->assertIsArray($arr);
        $this->assertNull($arr["error"]);
        $this->assertEquals($arr["searchString"], $searchString3);
        $this->assertEquals($arr["sourceString"], $sourceString);
        $this->assertTrue($arr["found"]);
        $this->assertEquals($arr["foundСounter"], 2);
        $this->assertEquals($arr["foundPositions"], 0);

        // 4
        $arr = $game->checkCondition($searchString4, $sourceString);
        $this->assertIsArray($arr);
        $this->assertNull($arr["error"]);
        $this->assertEquals($arr["searchString"], $searchString4);
        $this->assertEquals($arr["sourceString"], $sourceString);
        $this->assertTrue($arr["found"]);
        $this->assertEquals($arr["foundСounter"], 4);
        $this->assertEquals($arr["foundPositions"], 4);

        // 5
        $arr = $game->checkCondition($searchString5, $sourceString);
        $this->assertIsArray($arr);
        $this->assertNotNull($arr["error"]);
        $this->assertStringContainsStringIgnoringCase("error", $arr["error"]);
        $this->assertStringContainsString(sprintf("[%s]", mb_strlen($searchString5)), $arr["error"]);
        $this->assertStringContainsString(sprintf("[%s]", mb_strlen($sourceString)), $arr["error"]);

        // 6
        $arr = $game->checkCondition($searchString6, $sourceString);
        $this->assertIsArray($arr);
        $this->assertNotNull($arr["error"]);
        $this->assertStringContainsStringIgnoringCase("error", $arr["error"]);
        $this->assertStringContainsString(sprintf("[%s]", mb_strlen($searchString6)), $arr["error"]);
        $this->assertStringContainsString(sprintf("[%s]", mb_strlen($sourceString)), $arr["error"]);
    }

    public function testCheckOutput()
    {
        $game = new Game();
        $sourceString  = "4567";

        $searchString1 = "0123";
        $searchString2 = "4500";
        $searchString3 = "0045";
        $searchString4 = "4567";
        $searchString5 = "452";
        $searchString6 = "456712";

        // 1
        $result = $game->checkCondition($searchString1, $sourceString);
        $out = $game->checkOutput($result);
        $this->assertIsString($out);
        $this->assertStringNotContainsStringIgnoringCase("error", $out);

        // 2
        $result = $game->checkCondition($searchString2, $sourceString);
        $out = $game->checkOutput($result);
        $this->assertIsString($out);
        $this->assertStringNotContainsStringIgnoringCase("error", $out);

        // 3
        $result = $game->checkCondition($searchString3, $sourceString);
        $out = $game->checkOutput($result);
        $this->assertIsString($out);
        $this->assertStringNotContainsStringIgnoringCase("error", $out);

        // 4
        $result = $game->checkCondition($searchString4, $sourceString);
        $out = $game->checkOutput($result);
        $this->assertIsString($out);
        $this->assertStringNotContainsStringIgnoringCase("error", $out);

        // 5
        $result = $game->checkCondition($searchString5, $sourceString);
        $out = $game->checkOutput($result);
        $this->assertIsString($out);
        $this->assertStringContainsStringIgnoringCase("error", $out);

        // 6
        $result = $game->checkCondition($searchString6, $sourceString);
        $out = $game->checkOutput($result);
        $this->assertIsString($out);
        $this->assertStringContainsStringIgnoringCase("error", $out);
    }

    public function testExceptionMessage()
    {
        $game = new Game();
        $test = "test";
        $game->setExceptionMessage($test);

        $message = $game->getExceptionMessage();
        $this->assertEquals($message, $test);

        $message = $game->getExceptionMessage();
        $this->assertEmpty($message);
    }
}

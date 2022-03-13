<?php

namespace KostyanOrg\BullsAndCows;

final class Game
{

    private static $lastOut = "";

    private static $lastInput = null;

    private static $hiddenNumber = "0";

    private static $exceptionMessage = "";

    private static $debug = false;

    private static $history = [];

    private static $title = "";

    public function __construct(bool $debug = false)
    {
        $this->setDebug($debug);
    }

    public function setTitle(string $str): void
    {
        $filling = str_repeat("#", mb_strlen($str) + 4);
        self::$title = sprintf("%s\n# %s #\n%s\n\n", $filling, $str, $filling);
    }

    public function getTitle(): string
    {
        $title = self::$title;
        self::$title = "";
        return $title;
    }

    private function setDebug(bool $debug): void
    {
        self::$debug = $debug;
    }

    public function isDebug(): bool
    {
        return (bool)self::$debug;
    }

    public function setLastOut(string $str): void
    {
        self::$lastOut = $str;
    }

    public function getLastOut(): string
    {
        return (string)self::$lastOut;
    }

    public function setHistory(string $str): void
    {
        array_unshift(self::$history, $str);
    }

    public function getHistory(): array
    {
        return self::$history;
    }

    public function getHistoryString(int $size = 5): string
    {
        return implode(" ", array_slice($this->getHistory(), 0, $size));
    }

    public function resetHistory(): void
    {
        self::$history = [];
    }

    public function setLastInput(string $input): void
    {
        self::$lastInput = $input;
    }

    public function getLastInput(): string
    {
        return (string)self::$lastInput;
    }

    public function out(string $line): void
    {
        $lastOut = $this->getLastOut();
        if (mb_strlen($lastOut) > 0) $this->cleanUp($lastOut);

        $title = $this->getTitle();
        $line = $title .= $line;
        $line .= Menu::string($line);
        $line .= $this->isDebug() ? sprintf(
            "----------\nState=%s HidNumber=%s Lang=%d\n",
            State::toString(State::getCurrentState()),
            $this->getHiddenNumber(),
            Lang::getCurrentLang()
        )
            : "";

        $this->setLastOut($line);

        printf("%s", $line);
    }

    public function cleanUp(string $line): void
    {
        $arr = array_reverse(explode("\n", trim($line, "\n")));

        for ($i = 0; $i < count($arr); $i++) {

            $s = str_repeat(" ", mb_strlen($arr[$i]));

            printf("\X1B[A\r%s\r",  $s);
        }
    }

    public function getInput(): string
    {

        $line = trim(fgets(STDIN));

        $this->cleanUp($line);

        return $line;
    }

    public function getHiddenNumber(): string
    {
        return (string)self::$hiddenNumber;
    }

    public function setHiddenNumber(bool $uniq = false): void
    {
        self::$hiddenNumber = "";
        if ($uniq) {
            $arr = [];

            while (4 > count($arr)) {

                $number = mt_rand(0, 9);

                if (!in_array($number, $arr)) {
                    $arr[] = (string)$number;
                }
            }

            self::$hiddenNumber = implode("", $arr);
        } else {

            for ($i = 0; $i < 4; $i++) {
                self::$hiddenNumber .= (string)mt_rand(0, 9);
            }
        }
    }

    public function setHiddenNumberMy(string $str): bool
    {
        self::$hiddenNumber = "";

        if (mb_strlen($str) > 9 || mb_strlen($str) < 1) {
            return false;
        }
        self::$hiddenNumber = (string)$str;
        return true;
    }

    public function checkCondition(string $searchString, string $sourceString): array
    {
        $arrSearchString = mb_str_split($searchString);
        $cntSearchString = count($arrSearchString);
        $arrSourceString = mb_str_split($sourceString);
        $cntSourceString = count($arrSourceString);
        $error = null;
        $found = false; // найдено хотя бы 1 раз
        $foundСounter = 0; // сколько найдено
        $foundPositions = 0; // сколько правильных позиций

        if ($cntSearchString !== $cntSourceString) {
            return [
                "error" => sprintf(
                    Lang::get("Error! The length of string [%d] must be [%d]\n"),
                    $cntSearchString,
                    $cntSourceString
                )
            ];
        }

        for ($i = 0; $i < $cntSourceString; $i++) {

            if (strpos($sourceString, (string)$arrSearchString[$i]) !== false && !$found) {
                $found = true;
            }

            if (strpos($sourceString, (string)$arrSearchString[$i]) !== false) {

                $foundСounter++;
            }

            if ($arrSearchString[$i] === $arrSourceString[$i]) {
                $foundPositions++;
            }
        }

        return [
            "error" => $error,
            "searchString" => $searchString,
            "sourceString" => $sourceString,
            "found" => $found,
            "foundСounter" => $foundСounter,
            "foundPositions" => $foundPositions
        ];
    }

    public function checkOutput(array $result): string
    {
        if ($result["error"]) {
            return $result["error"];
        }

        if (!$result["found"]) {
            $this->setHistory(sprintf("%s(0|0)", $result["searchString"]));
            return Lang::get("There are no such numbers at all\n");
        }

        if ($result["foundPositions"]) {
            $this->setHistory(sprintf(
                "%s(%s|%s)",
                $result["searchString"],
                $result["foundСounter"],
                $result["foundPositions"]
            ));

            return sprintf(
                Lang::get("[%s] units exist \n[%s] units are located correctly\n"),
                $result["foundСounter"],
                $result["foundPositions"]
            );
        }

        $this->setHistory(sprintf(
            "%s(%s|0)",
            $result["searchString"],
            $result["foundСounter"]
        ));

        return sprintf(
            Lang::get("[%s] pieces exist \nincorrectly\n"),
            $result["foundСounter"]
        );
    }

    public function setExceptionMessage(string $str): void
    {
        self::$exceptionMessage = $str;
    }

    public function getExceptionMessage(): string
    {
        $msg = self::$exceptionMessage;
        self::$exceptionMessage = "";
        return $msg;
    }

    public function run()
    {

        while (true) {
            try {
                switch (State::getCurrentState()):

                    case State::WELLCOME:
                        $this->setTitle(Lang::get("main"));
                        $text = Lang::get("Welcome to the game!\n\n");
                        $text .= sprintf(Lang::get("[%s] Start a new game\n"), State::START);
                        $text .= sprintf(Lang::get("[%s] Select language\n"), State::SELECT_LANG);
                        $this->out($text);
                        $input = $this->getInput();

                        Router::go(State::get($input));
                        break;

                    case State::SELECT_LANG:
                        $this->setTitle(Lang::get("Language selection"));
                        $text = Lang::get("Two languages available.\n\n");
                        $text .= sprintf(Lang::get("[%s] English\n"), Lang::EN);
                        $text .= sprintf(Lang::get("[%s] Русский язык\n"), Lang::RU);
                        $this->out($text);

                        $input = $this->getInput();
                        Lang::set($input === (string)Lang::EN ? Lang::EN : Lang::RU);
                        Router::go(State::WELLCOME);
                        break;

                    case State::RULES:
                        $this->setTitle(Lang::get("rules"));
                        $text  = Lang::get("All you have to do is guess the number in the fewest possible number of tries.\n");
                        $text .= Lang::get("Hints will be given as you try.\n");
                        $text .= Lang::get("Recent attempts will be displayed in the history.\n");
                        $text .= Lang::get("For example: 1234(2|0) with the given number [2503].\n");
                        $text .= Lang::get("That means you entered the numbers 1234, where\n");
                        $text .= Lang::get("2 - two digits found, 0 - zero digits in place.\n");
                        $this->out($text);

                        $input = $this->getInput();

                        Router::go(State::get($input));
                        break;

                    case State::START:
                        $this->setTitle(Lang::get("A new game"));
                        $text = Lang::get("Need to choose which number to guess\n\n");
                        $text .= sprintf(Lang::get("[%s] - repeated\n"), State::GAME);
                        $text .= sprintf(Lang::get("[%s] - no repeats\n"), State::GAME_UNIQ);
                        $text .= sprintf(Lang::get("[%s] - set your own number\n"), State::START_MY);
                        $this->out($text);

                        $input = $this->getInput();
                        Router::go(State::get($input));
                        break;

                    case State::GAME:
                        $this->setTitle(Lang::get("New Repeating Number Game"));
                        $text  = Lang::get("Number to guess\n");
                        $text .= Lang::get("will contain numbers\n");
                        $text .= Lang::get("which may be repeated\n");
                        $text .= Lang::get("For example: [1133]\n");
                        $text .= Lang::get("Get started! The number has already been guessed.\n");
                        $this->out($text);

                        $this->setHiddenNumber();
                        $this->resetHistory();

                        $this->setLastInput($this->getInput());
                        Router::go(State::TRY);
                        break;

                    case State::GAME_UNIQ:
                        $this->setTitle(Lang::get("New game without repeating numbers"));
                        $text  = Lang::get("Number to guess\n");
                        $text .= Lang::get("will contain numbers\n");
                        $text .= Lang::get("which will not be repeated\n");
                        $text .= Lang::get("For example: [1234]\n");
                        $text .= Lang::get("Get started! The number has already been guessed.\n");
                        $this->out($text);

                        $this->setHiddenNumber(true);
                        $this->resetHistory();

                        $this->setLastInput($this->getInput());
                        Router::go(State::TRY);
                        break;

                    case State::START_MY:
                        $this->setTitle(Lang::get("New game with your number"));
                        $text  = Lang::get("Specify any number to be guessed.\n");
                        $text .= Lang::get("Maximum length can be 9 characters.\n");
                        $text .= Lang::get("For example: [1234]\n");
                        $this->out($text);

                        $this->resetHistory();

                        if ($this->setHiddenNumberMy($this->getInput())) {
                            Router::go(State::GAME_MY);
                        }
                        break;

                    case State::GAME_MY:
                        $this->setTitle(Lang::get("New game with your number"));
                        $text  = Lang::get("Number to guess\n");
                        $text .= Lang::get("will contain numbers\n");
                        $text .= Lang::get("which may be repeated\n");
                        $text .= Lang::get("For example: [1133]\n");
                        $text .= Lang::get("Get started! The number has already been guessed.\n");
                        $this->out($text);

                        $this->setLastInput($this->getInput());
                        Router::go(State::TRY);
                        break;

                    case State::TRY:
                        $this->setTitle(Lang::get("Playing"));
                        if ($this->getLastInput() === $this->getHiddenNumber()) {
                            $length = mb_strlen($this->getLastInput());
                            $this->setHistory(sprintf("%s(%s|%s)", $this->getLastInput(), $length, $length));
                            Router::go(State::WINNER);
                            break;
                        }

                        if ($this->getLastInput() === "!h") {
                            Router::go(State::HELP);
                            break;
                        }

                        if ($this->getLastInput() === "!s") {
                            Router::go(State::STOP);
                            break;
                        }

                        $checkCondition = $this->checkCondition($this->getLastInput(), $this->getHiddenNumber());
                        $checkResult = $this->checkOutput($checkCondition);

                        $this->out(sprintf(
                            Lang::get("Attempt: [%d] Your number: [%s]\n----\n%s----\nInput history: %s\n"),
                            count($this->getHistory()),
                            $this->getLastInput(),
                            $checkResult,
                            $this->getHistoryString(5)
                        ));

                        $this->setLastInput($this->getInput());
                        Router::go(State::TRY);
                        break;

                    case State::STOP:
                        $this->setTitle(Lang::get("Game over"));
                        $this->resetHistory();
                        $this->out(Lang::get("You have finished the game, use the menu.\n"));
                        $input = $this->getInput();
                        Router::go(State::get($input));
                        break;

                    case State::HELP:
                        $this->setTitle(Lang::get("Help"));
                        $this->out(sprintf(Lang::get("Number to guess: [%s]\n"), $this->getHiddenNumber()));
                        $this->setLastInput($this->getInput());
                        Router::go(State::TRY);
                        break;

                    case State::WINNER:
                        $this->setTitle(Lang::get("Victory!"));
                        $this->out(sprintf(
                            Lang::get("You guessed the number [%s] \nNumber of tries: [%d]\n"),
                            $this->getHiddenNumber(),
                            count($this->getHistory())
                        ));

                        $input = $this->getInput();
                        Router::go(State::WELLCOME);
                        break;

                    case State::EXCEPTION:
                        $this->setTitle(Lang::get("Error!"));
                        $this->out(sprintf(Lang::get("An error occurred: \n%s"), $this->getExceptionMessage()));

                        $input = $this->getInput();
                        Router::go(State::get($input));
                        break;

                    case State::EXIT:
                    default:
                        $this->out(Lang::get("Bye!\n"));
                        exit(0);
                endswitch;
            } catch (GameException $e) {
                $this->setExceptionMessage($e->getMessage());
                Router::go(State::EXCEPTION);
            }
        }
    }
}

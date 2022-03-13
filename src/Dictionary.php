<?php
// included in file Lang.php

use KostyanOrg\BullsAndCows\Lang;

return [
    // * test
    "test" => [
        Lang::RU => "тест"
    ],

    // * menu
    "exit" => [
        Lang::RU => "выход"
    ],
    "rules" => [
        Lang::RU => "правила"
    ],
    "main" => [
        Lang::RU => "начало"
    ],
    "stop the game" => [
        Lang::RU => "остановить игру"
    ],
    "menu" => [
        Lang::RU => "меню"
    ],

    // * router
    "Switching from [%d] %s to [%d] %s is forbidden!\n" => [
        Lang::RU => "Переход с [%d] %s на [%d] %s запрещён!\n"
    ],
    "No route from [%s]\n" => [
        Lang::RU => "Нет маршрута из [%s]\n"
    ],

    // * state
    "Action on command [%s] does not exist! Use the menu\n" => [
        Lang::RU => "Действия на команду [%s] не существует! Воспользуйтесь меню\n"
    ],
    "There is no action for command [%d]! Please use menu\n" => [
        Lang::RU => "Действия на команду [%d] не существует! Воспользуйтесь меню\n"
    ],

    // * game
    "Error! The length of string [%d] must be [%d]\n" => [
        Lang::RU => "Ошибка! Длина строки [%d] должна быть [%d]\n"
    ],
    "There are no such numbers at all\n" => [
        Lang::RU => "Таких цифр вообще нет\n"
    ],
    "[%s] units exist \n[%s] units are located correctly\n" => [
        Lang::RU => "[%s] шт. существуют \n[%s] шт. расположены правильно\n"
    ],
    "[%s] pieces exist \nincorrectly\n" => [
        Lang::RU => "[%s] шт. существуют \nрасположены неправильно\n"
    ],
    "Welcome to the game!\n\n" => [
        Lang::RU => "Добро пожаловать в игру!\n\n"
    ],
    "[%s] Start a new game\n" => [
        Lang::RU => "[%s] Начать новую игру\n"
    ],
    "All you have to do is guess the number in the fewest possible number of tries.\n" => [
        Lang::RU => "Всё что нужно - это угадать число за наименьшее количество попыток.\n"
    ],
    "Hints will be given as you try.\n" => [
        Lang::RU => "В процессе попыток будут даваться подсказки.\n"
    ],
    "Recent attempts will be displayed in the history.\n" => [
        Lang::RU => "Последние попытки будут отображаться в истории.\n"
    ],
    "For example: 1234(2|0) with the given number [2503].\n" => [
        Lang::RU => "Например: 1234(2|0) при загаданном числе [2503].\n"
    ],
    "That means you entered the numbers 1234, where\n" => [
        Lang::RU => "Это означает что ты указал цифры 1234, где\n"
    ],
    "2 - two digits found, 0 - zero digits in place.\n" => [
        Lang::RU => "2 - две цифры найдено, 0 - ноль цифр на своём месте.\n"
    ],
    "A new game" => [
        Lang::RU => "Новая игра"
    ],
    "[%s] Select language\n" => [
        Lang::RU => "[%s] Выбрать язык\n"
    ],
    "Language selection" => [
        Lang::RU => "Выбор языка"
    ],
    "Two languages available.\n\n" => [
        Lang::RU => "Доступно два языка.\n\n"
    ],
    "Need to choose which number to guess\n\n" => [
        Lang::RU => "Нужно выбрать какое число загадать\n\n"
    ],
    "[%s] - repeated\n" => [
        Lang::RU => "[%s] - с повторами\n"
    ],
    "[%s] - no repeats\n" => [
        Lang::RU => "[%s] - без повторов\n"
    ],
    "[%s] - set your own number\n" => [
        Lang::RU => "[%s] - задать своё число\n"
    ],
    "New Repeating Number Game" => [
        Lang::RU => "Новая игра с повторяющимися цифрами"
    ],
    "Number to guess\n" => [
        Lang::RU => "Число которое нужно отгадать\n"
    ],
    "will contain numbers\n" => [
        Lang::RU => "будет содержать в себе цифры\n"
    ],
    "which may be repeated\n" => [
        Lang::RU => "которые могут повторяться\n"
    ],
    "For example: [1133]\n" => [
        Lang::RU => "Например: [1133]\n"
    ],
    "Get started! The number has already been guessed.\n" => [
        Lang::RU => "Начинай! Число уже загадано.\n"
    ],
    "New game without repeating numbers" => [
        Lang::RU => "Новая игра без повторяющихся цифр"
    ],
    "which will not be repeated\n" => [
        Lang::RU => "которые повторяться не будут\n"
    ],
    "For example: [1234]\n" => [
        Lang::RU => "Например: [1234]\n"
    ],
    "New game with your number" => [
        Lang::RU => "Новая игра со своим числом"
    ],
    "Specify any number to be guessed.\n" => [
        Lang::RU => "Укажите любое число которое нужно будет отгадать.\n"
    ],
    "Maximum length can be 9 characters.\n" => [
        Lang::RU => "Максимальная длина может быть 9 символов.\n"
    ],
    "Playing" => [
        Lang::RU => "Играем"
    ],
    "Attempt: [%d] Your number: [%s]\n----\n%s----\nInput history: %s\n" => [
        Lang::RU => "Попытка: [%d] Твоё число: [%s]\n----\n%s----\nИстория ввода: %s\n"
    ],
    "Game over" => [
        Lang::RU => "Игра закончена"
    ],
    "You have finished the game, use the menu.\n" => [
        Lang::RU => "Вы закончили игру, воспользуйтесь меню.\n"
    ],
    "Help" => [
        Lang::RU => "Помощь"
    ],
    "Number to guess: [%s]\n" => [
        Lang::RU => "Число которое нужно отгадать: [%s]\n"
    ],
    "Victory!" => [
        Lang::RU => "Победа!"
    ],
    "You guessed the number [%s] \nNumber of tries: [%d]\n" => [
        Lang::RU => "Ты угадал число [%s] \nКоличество попыток: [%d]\n"
    ],
    "Error!" => [
        Lang::RU => "Ошибка!"
    ],
    "An error occurred: \n%s" => [
        Lang::RU => "Произошла ошибка: \n%s"
    ],
    "Bye!\n" => [
        Lang::RU => "Пока!\n"
    ],
];

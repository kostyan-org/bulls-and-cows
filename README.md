# Simple console game "Bulls And Cows"

At the moment the game has 3 modes

* guess the number in which characters can be repeated (4 characters)
* guess the number in which characters do not repeat (4 characters)
* enter your number (1 - 9 characters)

The game supports the choice of one of two languages English and Russian

If there is a difficulty, you can see the number by sending the command - **!h** during the game

required to run php >=7.4.27

install:

    composer create-project kostyan-org/bulls-and-cows

run:

    php ./bulls-and-cows/run.php

Debug mode is enabled in the run.php file:

    new Game(true)
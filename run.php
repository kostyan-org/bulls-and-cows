<?php

require_once 'vendor/autoload.php';

use KostyanOrg\BullsAndCows\Game;

(new Game(true))
    ->run();

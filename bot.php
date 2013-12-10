#!/usr/bin/env php
<?php

require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use SymfonyCon\Bot\Command\BotCommand;

$application = new Application();
$application->add(new BotCommand());
$application->run();
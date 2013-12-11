SymfonyCon IRC bot
==================

[![Build Status](https://travis-ci.org/jakzal/SymfonyConBot.png)](https://travis-ci.org/jakzal/SymfonyConBot)

Installation
------------

    curl -sS https://getcomposer.org/installer | php
    ./composer.phar install

Usage
-----

Get help:

    php bot.php symfonycon:bot:run -h

Example:

    php bot.php symfonycon:bot:run --nickname=MrBot random-channel

Contributing
------------

Look at the example plugin in `src/SymfonyCon/Bot/Plugin` and send us a pull request! :)

Warning
-------

Please do not run the same bot with the beerplugin or similar in the same channel. It will cause a loop and you will be banned and just cause a lot of spam.

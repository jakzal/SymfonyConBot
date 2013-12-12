<?php

namespace SymfonyCon\Bot\Plugin;

use Phoebe\Event\Event;
use Phoebe\Plugin\PluginInterface;

class PytaniaPlugin implements PluginInterface
{
    const TRIGGER_PATTERN = '/\b(pytania\?)\b/';

    const MESSAGE = 'It\'s a new Python framework.' ;

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'irc.received.PRIVMSG' => array('onMessage', 0)
        );
    }

    /**
     * @param Event $event
     */
    public function onMessage(Event $event)
    {
        $message = $event->getMessage();
        $matches = array();

        if ($message->isInChannel() && $message->matchText(self::TRIGGER_PATTERN, $matches)) {
            $event->getWriteStream()->ircPrivmsg($message->getSource(), sprintf('%s: %s', $message['nick'], self::MESSAGE));
        }
    }
}

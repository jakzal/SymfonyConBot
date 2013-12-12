<?php

namespace SymfonyCon\Bot\Plugin;

use Phoebe\Plugin\PluginInterface;
use Phoebe\Event\Event;

class GaufretteSupporterPlugin implements PluginInterface
{
    const TRIGGER_PATTERN = '/^I like Gaufrette$/';
    const MESSAGE = 'Find @l3l0 and buy him a pint';

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'irc.received.PRIVMSG' => array('onMessage', 0)
        );
    }

    public function onMessage(Event $event)
    {
        $message = $event->getMessage();
        $matches = array();

        if ($message->isInChannel() && $message->matchText(self::TRIGGER_PATTERN, $matches)) {
            $event->getWriteStream()->ircPrivmsg($message->getSource(), sprintf('%s: %s', $message['nick'], self::MESSAGE));
        }
    }
}

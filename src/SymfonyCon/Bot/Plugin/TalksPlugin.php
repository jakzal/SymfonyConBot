<?php

namespace SymfonyCon\Bot\Plugin;

use Phoebe\Event\Event;
use Phoebe\Plugin\PluginInterface;

class TalksPlugin implements PluginInterface
{
    const TRIGGER_PATTERN = '/^next talk$/';

    private $talks = array(
        1386835200 => array(
            'Keynote by Fabien Potencier'
        ),
        1386839400 => array(
            'Diving deep into Twig by Matthias Noback',
            'How to automatize your infrastructure with Chef by Grégoire Pineau'
        ),
        1386843000 => array(
            'Build Awesome REST APIs With Symfony2 by William Durand and Lukas Kahwe Smith',
            'Simplify your code with annotations by Piotr Pasich'
        ),
        1386851400 => array(
            'Increase productivity with Doctrine2 extensions by Gediminas Morkevicius',
            'Pitching Symfony to your Client by John La'
        ),
        1386855000 => array(
            'Symfony2 Content Management in 40 minutes by David Buchmann',
            'How Kris Writes Symfony Apps Kris Wallsmith'
        ),
        1386859200 => array(
            'Cool like Frontend Developer: Grunt, RequireJS, Bower and other Tools by Ryan Weaver',
            'Community Building with Mentoring: What makes people crazy happy to work on an open source project? by Cathy Theys'
        ),
        1386921600 => array(
            'Symfony2 Forms: Past, Present, Future by Bernhard Schussek',
            'Async PHP with React by Jeremy Mikola'
        ),
        1386925200 => array(
            'Drop ACE, use voters by Marie Minasyan',
            'The Proxy pattern in PHP by Marco Pivetta'
        ),
        1386929400 => array(
            'Mastering the Security component\'s authentication mechanism by Joseph Rouff',
            'Symfony components in the wild by Jakub Zalas'
        ),
        1386937800 => array(
            'Taming Runaway Silex Apps by Dave Marshall',
            'Application monitoring with Heka and statsd by Jordi Boggiano'
        ),
        1386941400 => array(
            'Decouple your application with (Domain-)Events by Benjamin Eberlei',
            'How to build Console Applications by Daniel Gomes'
        ),
        1386946800 => array(
            'Lightning Talks'
        )
    );

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
            foreach ($this->nextTalk() as $talk) {
                $event->getWriteStream()->ircPrivmsg($message->getSource(), sprintf('%s: %s', $message['nick'], $talk));
            }
        }
    }

    private function nextTalk()
    {
        $now = date('U');

        foreach ($this->talks as $time => $talks) {
            if ($now < $time) {
                return $talks;
            }
        }

        return array('Wait for SymfonyCon 2014');
    }
}

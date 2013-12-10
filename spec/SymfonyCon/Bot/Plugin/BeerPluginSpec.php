<?php

namespace spec\SymfonyCon\Bot\Plugin;

use Phergie\Irc\Client\React\WriteStream;
use Phoebe\Event\Event;
use Phoebe\Message\ReceivedMessage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use SymfonyCon\Bot\Plugin\BeerPlugin;

class BeerPluginSpec extends ObjectBehavior
{
    function it_is_a_phoebe_plugin()
    {
        $this->shouldHaveType('Phoebe\Plugin\PluginInterface');
    }

    function it_subscribes_to__privmsg_event()
    {
        $this->getSubscribedEvents()->shouldReturn(array('irc.received.PRIVMSG' => array('onMessage' , 0)));
    }

    function it_educates_how_to_order_a_beer(Event $event, ReceivedMessage $message, WriteStream $writeStream)
    {
        $event->getMessage()->willReturn($message);
        $event->getWriteStream()->willReturn($writeStream);

        $message->isInChannel()->willReturn(true);
        $message->matchText(BeerPlugin::TRIGGER_PATTERN, Argument::any())->willReturn(true);
        $message->getSource()->willReturn('#symfony');
        $message->offsetGet('nick')->willReturn('foobar');

        $writeStream->ircPrivmsg('#symfony', 'foobar: '.BeerPlugin::MESSAGE)->shouldBeCalled();

        $this->onMessage($event);
    }

    function it_is_silent_otherwise(Event $event, ReceivedMessage $message, WriteStream $writeStream)
    {
        $event->getMessage()->willReturn($message);
        $event->getWriteStream()->willReturn($writeStream);

        $message->isInChannel()->willReturn(true);
        $message->matchText(BeerPlugin::TRIGGER_PATTERN, Argument::any())->willReturn(false);

        $writeStream->ircPrivmsg(Argument::any())->shouldNotBeCalled();

        $this->onMessage($event);
    }
}

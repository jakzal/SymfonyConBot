<?php

namespace spec\SymfonyCon\Bot\Plugin;

use Phergie\Irc\Client\React\WriteStream;
use Phoebe\Event\Event;
use Phoebe\Message\ReceivedMessage;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GaufretteSupporterPluginSpec extends ObjectBehavior
{
    function it_is_a_phoebe_plugin()
    {
        $this->shouldHaveType('Phoebe\Plugin\PluginInterface');
    }

    function it_subscribes_to_privmsg_event()
    {
        $this->getSubscribedEvents()->shouldReturn(array('irc.received.PRIVMSG' => array('onMessage' , 0)));
    }

    function it_informs_that_gaufrette_maintainer_need_beer_to_do_open_source(
        Event $event,
        ReceivedMessage $message,
        WriteStream $writeStream
    )
    {
        $event->getMessage()->willReturn($message);
        $event->getWriteStream()->willReturn($writeStream);

        $message->isInChannel()->willReturn(true);
        $message->matchText('/^I like Gaufrette$/', Argument::any())->willReturn(true);
        $message->getSource()->willReturn('#symfony');
        $message->offsetGet('nick')->willReturn('gaufretteUser');
        $writeStream->ircPrivmsg('#symfony', 'gaufretteUser: Find @l3l0 and buy him a pint')->shouldBeCalled();

        $this->onMessage($event);
    }
}

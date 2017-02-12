<?php

namespace spec\OpenCounter\Application\Command\Counter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use OpenCounter\Application\Command\Counter\CounterRemoveCommand;

class CounterRemoveCommandSpec extends ObjectBehavior
{
    function it_creates_request()
    {
        $this->beConstructedWith('a-plain-string-id', 'a-plain-string-name');
        $this->shouldHaveType(CounterRemoveCommand::class);
        $this->id()->shouldReturn('a-plain-string-id');
    }
}

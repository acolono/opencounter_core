<?php

namespace spec\OpenCounter\Application\Command\Counter;

use OpenCounter\Application\Command\Counter\CounterRemoveCommand;
use PhpSpec\ObjectBehavior;

/**
 * Class CounterRemoveCommandSpec
 * @package spec\OpenCounter\Application\Command\Counter
 */
class CounterRemoveCommandSpec extends ObjectBehavior
{
    function it_creates_request()
    {
        $this->beConstructedWith('a-plain-string-id', 'a-plain-string-name');
        $this->shouldHaveType(CounterRemoveCommand::class);
        $this->id()->shouldReturn('a-plain-string-id');
    }
}

<?php

namespace spec\OpenCounter\Application\Command\Counter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use OpenCounter\Application\Command\Counter\CounterAddCommand;

class CounterAddCommandSpec extends ObjectBehavior
{
    function it_creates_a_counter_command()
    {
        $this->beConstructedWith('testcounter', '2', 'active', 'testpassword');
        $this->shouldHaveType(CounterAddCommand::class);

// TODO: id should be generated at this point.
//        $this->id()->shouldNotBe(null);
        $this->name()->shouldReturn('testcounter');
        $this->password()->shouldReturn('testpassword');
        $this->status()->shouldReturn('active');
        $this->value()->shouldReturn('2');
    }
}

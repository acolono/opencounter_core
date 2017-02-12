<?php

namespace spec\OpenCounter\Application\Query\Counter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use OpenCounter\Application\Query\Counter\CounterOfIdQuery;

class CounterOfIdQuerySpec extends ObjectBehavior
{
    function it_creates_a_query()
    {
        $this->beConstructedWith('user-id');
        $this->shouldHaveType(CounterOfIdQuery::class);
        $this->id()->shouldReturn('user-id');
    }

    function it_cannot_creates_a_query_with_null_id()
    {
        $this->beConstructedWith(null);
        $this->shouldThrow(new \InvalidArgumentException('ID cannot be null'))
          ->duringInstantiation();
    }
}

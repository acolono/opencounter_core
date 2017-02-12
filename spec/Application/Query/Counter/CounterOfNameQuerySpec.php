<?php

namespace spec\OpenCounter\Counter\Application\Query\Counter;

use OpenCounter\Application\Query\Counter\CounterOfIdQuery;
use OpenCounter\Application\Query\Counter\CounterOfNameQuery;
use PhpSpec\ObjectBehavior;

class CounterOfNameQuerySpec extends ObjectBehavior
{
    function it_creates_a_query()
    {
        $this->beConstructedWith('user-name');
        $this->shouldHaveType(CounterOfNameQuery::class);
        $this->id()->shouldReturn('user-name');
    }

    function it_cannot_creates_a_query_with_null_name()
    {
        $this->beConstructedWith(null);
        $this->shouldThrow(new \InvalidArgumentException('Name cannot be null'))
          ->duringInstantiation();
    }
}

<?php

namespace spec\OpenCounter\Application\Query\Counter;

use OpenCounter\Application\Query\Counter\CounterOfIdQuery;
use OpenCounter\Application\Query\Counter\CounterQuery;
use PhpSpec\ObjectBehavior;

/**
 * Class CounterOfIdQuerySpec
 * @package spec\OpenCounter\Application\Query\Counter
 */
class CounterOfIdQuerySpec extends ObjectBehavior
{
    function it_creates_a_query()
    {
        $this->beConstructedWith('0000000');
        $this->shouldHaveType(CounterOfIdQuery::class);
        $this->shouldImplement(CounterQuery::class);
        $this->id()->shouldReturn('0000000');
    }

    function it_cannot_creates_a_query_with_null_id()
    {
        $this->beConstructedWith(null);
        $this->shouldThrow(new \InvalidArgumentException('ID cannot be null'))
          ->duringInstantiation();
    }
}

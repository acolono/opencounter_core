<?php

namespace spec\OpenCounter\Domain\Exception\Counter;

use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;
use PhpSpec\ObjectBehavior;

/**
 * Class CounterNotFoundExceptionSpec
 * @package spec\OpenCounter\Domain\Exception\Counter
 */
class CounterNotFoundExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CounterNotFoundException::class);
    }
}

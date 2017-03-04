<?php

namespace spec\OpenCounter\Domain\Exception\Counter;

use OpenCounter\Domain\Exception\Counter\CounterLockedException;
use PhpSpec\ObjectBehavior;

/**
 * Class CounterLockedExceptionSpec
 * @package spec\OpenCounter\Domain\Exception\Counter
 */
class CounterLockedExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CounterLockedException::class);
    }
}

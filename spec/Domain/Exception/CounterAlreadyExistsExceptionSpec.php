<?php

namespace spec\OpenCounter\Domain\Exception\Counter;

use PhpSpec\ObjectBehavior;

/**
 * Class CounterAlreadyExistsExceptionSpec
 * @package spec\OpenCounter\Domain\Exception\Counter
 */
class CounterAlreadyExistsExceptionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('OpenCounter\Domain\Exception\Counter\CounterAlreadyExistsException');
    }
}

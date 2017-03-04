<?php

namespace spec\OpenCounter\Domain\Model\Counter;

use PhpSpec\ObjectBehavior;

/**
 * Class CounterNameSpec
 * @package spec\OpenCounter\Domain\Model\Counter
 */
class CounterNameSpec extends ObjectBehavior
{

    function let()
    {
        $this->beConstructedWith('opencounter');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('OpenCounter\Domain\Model\Counter\CounterName');
    }

    function its_Name()
    {
        $this->name()->shouldReturn('opencounter');
    }

    function its_to_string()
    {
        $this->__toString()->shouldReturn('opencounter');
    }
}

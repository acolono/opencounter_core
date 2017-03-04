<?php

namespace spec\OpenCounter\Domain\Model\Counter;

use OpenCounter\Domain\Model\Counter\CounterId;
use PhpSpec\ObjectBehavior;

/**
 * Class CounterIdSpec
 * @package spec\OpenCounter\Domain\Model\Counter
 */
class CounterIdSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('anId');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('\OpenCounter\Domain\Model\Counter\CounterId');
    }

    function its_uuid()
    {
        $this->uuid()->shouldReturn('anId');
    }

    /**
     * @param \OpenCounter\Domain\Model\Counter\CounterId|\PhpSpec\Wrapper\Collaborator $counterId
     */
    function it_should_not_be_equals(CounterId $counterId)
    {
        $other_uuid = 'anotherId';

        $counterId->uuid()->shouldBeCalled()->willReturn($other_uuid);
        $this->equals($counterId)->shouldReturn(false);
    }

    /**
     * @param \OpenCounter\Domain\Model\Counter\CounterId|\PhpSpec\Wrapper\Collaborator $counterId
     */
    function it_should_be_equals(CounterId $counterId)
    {
        $counterId->uuid()->shouldBeCalled()->willReturn('anId');
        $this->equals($counterId)->shouldReturn(true);
    }
}

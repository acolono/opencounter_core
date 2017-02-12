<?php

namespace spec\OpenCounter\Service\Counter;

use OpenCounter\Application\Command\Counter\CounterAddCommand;
use OpenCounter\Application\Service\Counter\CounterAddService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CounterAddServiceSpec extends ObjectBehavior
{
    function let(AddCounterHandler $handler)
    {
        $this->beConstructedWith($handler);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AddCounterService::class);
    }

    function it_implements_application_service()
    {
        $this->shouldHaveType(ApplicationService::class);
    }

    function it_executes(
      AddCounterHandler $handler,
      CounterAddCommand $aCommand
    ) {
        $handler->__invoke($aCommand)->shouldBeCalled();

        $this->execute($aCommand);
    }
}

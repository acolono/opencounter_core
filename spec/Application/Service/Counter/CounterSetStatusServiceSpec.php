<?php

namespace spec\OpenCounter\Application\Service\Counter;

use Ddd\Application\Service\ApplicationService;
use PhpSpec\ObjectBehavior;
use OpenCounter\Application\Command\Counter\CounterSetStatusCommand;
use OpenCounter\Application\Command\Counter\CounterSetStatusHandler;
use OpenCounter\Application\Service\Counter\CounterSetStatusService;

class CounterSetStatusServiceSpec extends ObjectBehavior
{
    function let(CounterSetStatusHandler $handler)
    {
        $this->beConstructedWith($handler);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CounterSetStatusService::class);
    }

    function it_implements_application_service()
    {
        $this->shouldHaveType(ApplicationService::class);
    }

    function it_executes(
      CounterSetStatusHandler $handler,
      CounterSetStatusCommand $aCommand
    ) {
        $handler->__invoke($aCommand)->shouldBeCalled();

        $this->execute($aCommand);
    }
}

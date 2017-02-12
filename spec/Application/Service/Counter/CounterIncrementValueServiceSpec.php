<?php

namespace spec\OpenCounter\Application\Service\Counter;

use Ddd\Application\Service\ApplicationService;
use PhpSpec\ObjectBehavior;
use OpenCounter\Application\Command\Counter\CounterIncrementValueCommand;
use OpenCounter\Application\Command\Counter\CounterIncrementValueHandler;
use OpenCounter\Application\Service\Counter\CounterIncrementValueService;

class CounterIncrementValueServiceSpec extends ObjectBehavior
{
    function let(CounterIncrementValueHandler $handler)
    {
        $this->beConstructedWith($handler);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CounterIncrementValueService::class);
    }

    function it_implements_application_service()
    {
        $this->shouldHaveType(ApplicationService::class);
    }

    function it_executes(
      CounterIncrementValueHandler $handler,
      CounterIncrementValueCommand $aCommand
    ) {
        $handler->__invoke($aCommand)->shouldBeCalled();

        $this->execute($aCommand);
    }
}

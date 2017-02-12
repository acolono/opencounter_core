<?php

namespace spec\OpenCounter\Application\Service\Counter;

use Ddd\Application\Service\ApplicationService;
use PhpSpec\ObjectBehavior;
use OpenCounter\Application\Command\Counter\CounterResetValueCommand;
use OpenCounter\Application\Command\Counter\CounterResetValueHandler;
use OpenCounter\Application\Service\Counter\CounterResetValueService;

class CounterResetValueServiceSpec extends ObjectBehavior
{
    function let(CounterResetValueHandler $handler)
    {
        $this->beConstructedWith($handler);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CounterResetValueService::class);
    }

    function it_implements_application_service()
    {
        $this->shouldHaveType(ApplicationService::class);
    }

    function it_executes(
      CounterResetValueHandler $handler,
      CounterResetValueCommand $aCommand
    ) {
        $handler->__invoke($aCommand)->shouldBeCalled();

        $this->execute($aCommand);
    }
}

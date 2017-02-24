<?php

namespace spec\OpenCounter\Application\Service\Counter;

use OpenCounter\Application\Service\Counter\ApplicationService;

use PhpSpec\ObjectBehavior;
use OpenCounter\Application\Command\Counter\CounterRemoveCommand;
use OpenCounter\Application\Command\Counter\CounterRemoveHandler;
use OpenCounter\Application\Service\Counter\CounterRemoveService;

class CounterRemoveServiceSpec extends ObjectBehavior
{

    function let(CounterRemoveHandler $handler)
    {
        $this->beConstructedWith($handler);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CounterRemoveService::class);
    }

    function it_implements_application_service()
    {
        $this->shouldHaveType(ApplicationService::class);

    }

    function it_executes(
      CounterRemoveHandler $handler,
      CounterRemoveCommand $aCommand
    ) {
        $handler->__invoke($aCommand)->shouldBeCalled();

        $this->execute($aCommand);
    }
}

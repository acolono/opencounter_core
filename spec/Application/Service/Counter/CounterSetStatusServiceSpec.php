<?php

namespace spec\OpenCounter\Application\Service\Counter;

use OpenCounter\Application\Command\Counter\CounterSetStatusCommand;
use OpenCounter\Application\Command\Counter\CounterSetStatusHandler;
use OpenCounter\Application\Service\Counter\ApplicationService;
use OpenCounter\Application\Service\Counter\CounterSetStatusService;
use PhpSpec\ObjectBehavior;

/**
 * Class CounterSetStatusServiceSpec
 * @package spec\OpenCounter\Application\Service\Counter
 */
class CounterSetStatusServiceSpec extends ObjectBehavior
{
    /**
     * @param \OpenCounter\Application\Command\Counter\CounterSetStatusHandler|\PhpSpec\Wrapper\Collaborator $handler
     */
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

    /**
     * @param \OpenCounter\Application\Command\Counter\CounterSetStatusHandler|\PhpSpec\Wrapper\Collaborator $handler
     * @param \OpenCounter\Application\Command\Counter\CounterSetStatusCommand|\PhpSpec\Wrapper\Collaborator $aCommand
     */
    function it_executes(
        CounterSetStatusHandler $handler,
        CounterSetStatusCommand $aCommand
    ) {
        $handler->__invoke($aCommand)->shouldBeCalled();

        $this->execute($aCommand);
    }
}

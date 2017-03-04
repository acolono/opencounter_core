<?php

namespace spec\OpenCounter\Service\Counter;

use OpenCounter\Application\Command\Counter\CounterAddCommand;
use OpenCounter\Application\Command\Counter\CounterAddHandler;
use OpenCounter\Application\Service\Counter\ApplicationService;
use OpenCounter\Application\Service\Counter\CounterAddService;
use PhpSpec\ObjectBehavior;

/**
 * Class CounterAddServiceSpec
 * @package spec\OpenCounter\Service\Counter
 */
class CounterAddServiceSpec extends ObjectBehavior
{
    /**
     * @param \OpenCounter\Application\Command\Counter\CounterAddHandler|\PhpSpec\Wrapper\Collaborator $handler
     */
    function let(CounterAddHandler $handler)
    {
        $this->beConstructedWith($handler);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CounterAddService::class);
    }

    function it_implements_application_service()
    {
        $this->shouldHaveType(ApplicationService::class);
    }

    /**
     * @param \OpenCounter\Application\Command\Counter\CounterAddHandler|\PhpSpec\Wrapper\Collaborator $handler
     * @param \OpenCounter\Application\Command\Counter\CounterAddCommand|\PhpSpec\Wrapper\Collaborator $aCommand
     */
    function it_executes(
        CounterAddHandler $handler,
        CounterAddCommand $aCommand
    ) {
        $handler->__invoke($aCommand)->shouldBeCalled();

        $this->execute($aCommand);
    }
}

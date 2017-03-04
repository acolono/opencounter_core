<?php

namespace spec\OpenCounter\Application\Service\Counter;

use OpenCounter\Application\Command\Counter\CounterRemoveCommand;
use OpenCounter\Application\Command\Counter\CounterRemoveHandler;
use OpenCounter\Application\Service\Counter\ApplicationService;
use OpenCounter\Application\Service\Counter\CounterRemoveService;
use PhpSpec\ObjectBehavior;

/**
 * Class CounterRemoveServiceSpec
 * @package spec\OpenCounter\Application\Service\Counter
 */
class CounterRemoveServiceSpec extends ObjectBehavior
{
    /**
     * @param \OpenCounter\Application\Command\Counter\CounterRemoveHandler|\PhpSpec\Wrapper\Collaborator $handler
     */
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

    /**
     * @param \OpenCounter\Application\Command\Counter\CounterRemoveHandler|\PhpSpec\Wrapper\Collaborator $handler
     * @param \OpenCounter\Application\Command\Counter\CounterRemoveCommand|\PhpSpec\Wrapper\Collaborator $aCommand
     */
    function it_executes(
        CounterRemoveHandler $handler,
        CounterRemoveCommand $aCommand
    ) {
        $handler->__invoke($aCommand)->shouldBeCalled();

        $this->execute($aCommand);
    }
}

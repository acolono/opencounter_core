<?php

namespace spec\OpenCounter\Application\Service\Counter;

use OpenCounter\Application\Command\Counter\CounterIncrementValueCommand;
use OpenCounter\Application\Command\Counter\CounterIncrementValueHandler;
use OpenCounter\Application\Service\Counter\ApplicationService;
use OpenCounter\Application\Service\Counter\CounterIncrementValueService;
use PhpSpec\ObjectBehavior;

/**
 * Class CounterIncrementValueServiceSpec
 * @package spec\OpenCounter\Application\Service\Counter
 */
class CounterIncrementValueServiceSpec extends ObjectBehavior
{
    /**
     * @param \OpenCounter\Application\Command\Counter\CounterIncrementValueHandler|\PhpSpec\Wrapper\Collaborator $handler
     */
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

    /**
     * @param \OpenCounter\Application\Command\Counter\CounterIncrementValueHandler|\PhpSpec\Wrapper\Collaborator $handler
     * @param \OpenCounter\Application\Command\Counter\CounterIncrementValueCommand|\PhpSpec\Wrapper\Collaborator $aCommand
     */
    function it_executes(
        CounterIncrementValueHandler $handler,
        CounterIncrementValueCommand $aCommand
    ) {
        $handler->__invoke($aCommand)->shouldBeCalled();

        $this->execute($aCommand);
    }
}

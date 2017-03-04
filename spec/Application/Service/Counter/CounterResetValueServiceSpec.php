<?php

namespace spec\OpenCounter\Application\Service\Counter;

use OpenCounter\Application\Command\Counter\CounterResetValueCommand;
use OpenCounter\Application\Command\Counter\CounterResetValueHandler;
use OpenCounter\Application\Service\Counter\ApplicationService;
use OpenCounter\Application\Service\Counter\CounterResetValueService;
use PhpSpec\ObjectBehavior;

/**
 * Class CounterResetValueServiceSpec
 * @package spec\OpenCounter\Application\Service\Counter
 */
class CounterResetValueServiceSpec extends ObjectBehavior
{
    /**
     * @param \OpenCounter\Application\Command\Counter\CounterResetValueHandler|\PhpSpec\Wrapper\Collaborator $handler
     */
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

    /**
     * it_executes
     *
     * specify how the handler will be invoked
     *
     * @param \OpenCounter\Application\Command\Counter\CounterResetValueHandler|\PhpSpec\Wrapper\Collaborator $handler
     * @param \OpenCounter\Application\Command\Counter\CounterResetValueCommand|\PhpSpec\Wrapper\Collaborator $aCommand
     */
    function it_executes(
        CounterResetValueHandler $handler,
        CounterResetValueCommand $aCommand
    ) {
        $handler->__invoke($aCommand)->shouldBeCalled();

        $this->execute($aCommand);
    }
}

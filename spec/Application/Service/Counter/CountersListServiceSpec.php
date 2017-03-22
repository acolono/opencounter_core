<?php

namespace spec\OpenCounter\Application\Service\Counter;

use OpenCounter\Application\Query\Counter\CountersListHandler;
use OpenCounter\Application\Query\Counter\CountersListQuery;
use OpenCounter\Application\Service\Counter\ApplicationService;
use OpenCounter\Application\Service\Counter\CountersListService;
use PhpSpec\ObjectBehavior;

/**
 * Class CountersListServiceSpec
 * @package spec\OpenCounter\Application\Service\Counter
 */
class CountersListServiceSpec extends ObjectBehavior
{
    /**
     * @param \OpenCounter\Application\Query\Counter\CountersListHandler $handler
     */
    function let(CountersListHandler $handler)
    {
        $this->beConstructedWith($handler);
    }

    /**
     *
     */
    function it_is_initializable()
    {
        $this->shouldHaveType(CountersListService::class);
    }

    function it_implements_application_service()
    {
        $this->shouldHaveType(ApplicationService::class);
    }

    /**
     * it_executes
     * @param \OpenCounter\Application\Query\Counter\CountersListHandler $handler
     */
    function it_executes(
      CountersListHandler $handler
    ) {
        $handler->__invoke()->shouldBeCalled();

        $this->execute();
    }
}

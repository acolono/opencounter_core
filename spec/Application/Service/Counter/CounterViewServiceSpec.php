<?php
/**
 * Created by PhpStorm.
 * User: rosenstrauch
 * Date: 2/16/17
 * Time: 5:36 PM
 */
namespace spec\OpenCounter\Application\Service\Counter;

use OpenCounter\Application\Query\Counter\CounterOfNameHandler;
use OpenCounter\Application\Query\Counter\CounterOfNameQuery;
use OpenCounter\Application\Service\Counter\ApplicationService;
use OpenCounter\Application\Service\Counter\CounterViewService;
use PhpSpec\ObjectBehavior;

/**
 * Class CounterViewServiceSpec
 * @package spec\OpenCounter\Application\Service\Counter
 */
class CounterViewServiceSpec extends ObjectBehavior
{
    /**
     * @param \OpenCounter\Application\Query\Counter\CounterOfNameHandler|\PhpSpec\Wrapper\Collaborator $handler
     */
    function let(CounterOfNameHandler $handler)
    {
        $this->beConstructedWith($handler);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CounterViewService::class);
    }

    function it_implements_application_service()
    {
        $this->shouldHaveType(ApplicationService::class);
    }

    /**
     * @param \OpenCounter\Application\Query\Counter\CounterOfNameHandler|\PhpSpec\Wrapper\Collaborator $handler
     * @param \OpenCounter\Application\Query\Counter\CounterOfNameQuery|\PhpSpec\Wrapper\Collaborator   $aQuery
     */
    function it_executes(
        CounterOfNameHandler $handler,
        CounterOfNameQuery $aQuery
    ) {
        $handler->__invoke($aQuery)->shouldBeCalled();

        $this->execute($aQuery);
    }
}

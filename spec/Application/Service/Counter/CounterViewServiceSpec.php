<?php
/**
 * Created by PhpStorm.
 * User: rosenstrauch
 * Date: 2/16/17
 * Time: 5:36 PM
 */

namespace spec\OpenCounter\Application\Service\Counter;

use Ddd\Application\Service\ApplicationService;
use OpenCounter\Application\Query\Counter\CounterOfNameHandler;
use OpenCounter\Application\Query\Counter\CounterOfNameQuery;
use PhpSpec\ObjectBehavior;

use OpenCounter\Application\Service\Counter\CounterViewService;

class CounterViewServiceSpec extends ObjectBehavior
{

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

    function it_executes(
      CounterOfNameHandler $handler,
      CounterOfNameQuery $aQuery
    ) {
        $handler->__invoke($aQuery)->shouldBeCalled();

        $this->execute($aQuery);
    }
}
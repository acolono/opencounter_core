<?php

namespace spec\OpenCounter\Application\Query\Counter;

use OpenCounter\Application\Query\Counter\CountersListHandler;
use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Model\Counter\CounterValue;
use OpenCounter\Domain\Repository\CounterRepository;
use PhpSpec\ObjectBehavior;

/**
 * Class CountersListHandlerSpec
 * @inheritdoc
 * @package spec\OpenCounter\Application\Query\Counter
 */
class CountersListHandlerSpec extends ObjectBehavior
{
    /**
     * @var
     */
    private $dummyCounter;

    /**
     * @param \OpenCounter\Domain\Repository\CounterRepository $repository
     */
    function let(CounterRepository $repository)
    {
        $this->dummyCounter = new Counter(new CounterId($repository->nextIdentity()),
          new CounterName('dummycounter'), new CounterValue('1'), 'active',
          'passwordplaceholder');
        $repository->save($this->dummyCounter);

        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CountersListHandler::class);
    }

    /**
     * it_lists_all_counters
     *
     * @param \OpenCounter\Domain\Repository\CounterRepository $repository
     */
    function it_lists_all_counters(
      CounterRepository $repository
    ) {

        $counters = [$this->dummyCounter];
        $repository->getAllCounters()
          ->shouldBeCalled()
          ->willReturn($counters);
        $this->__invoke()->shouldReturn($counters);
    }

}

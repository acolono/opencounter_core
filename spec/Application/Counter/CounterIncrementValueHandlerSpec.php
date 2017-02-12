<?php
/**
 * Created by PhpStorm.
 * Counter: rosenstrauch
 * Date: 2/16/17
 * Time: 5:06 PM
 */

namespace spec\OpenCounter\Application\Command\Counter;

use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Repository\CounterRepository;
use OpenCounter\Domain\Repository\PersistentCounterRepository;
use OpenCounter\Http\CounterBuildService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use OpenCounter\Application\Command\Counter\CounterIncrementValueCommand;
use OpenCounter\Application\Command\Counter\CounterIncrementValueHandler;
use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;

class CounterIncrementValueHandlerSpec extends ObjectBehavior
{
    function let(PersistentCounterRepository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CounterIncrementValueHandler::class);
    }

    function it_does_not_increment_because_Counter_does_no_exist(
      CounterIncrementValueCommand $command,
      PersistentCounterRepository $repository
    ) {
        $command->name()
          ->shouldBeCalled()
          ->willReturn('non-exist-Counter-name');
        $repository->getCounterByName(new CounterName('non-exist-Counter-name'))
          ->shouldBeCalled()
          ->willReturn(null);

        $this->shouldThrow(CounterNotFoundException::class)
          ->during__invoke($command);

    }

    function it_increments_a_counter(
      CounterIncrementValueCommand $command,
      PersistentCounterRepository $repository,
      Counter $counter
    ) {

        $command->name()->shouldBeCalled()->willReturn('Counter-name');
        $command->value()->shouldBeCalled()->willReturn('1');

//            $counter = new CounterBuildService($repository,)

        $repository->getCounterByName(new CounterName('Counter-name'))
          ->shouldBeCalled()
          ->willReturn($counter);

        $counter->increaseCount($command->value()->shouldBeCalled());

        $repository->update($counter)->shouldBeCalled();

        $this->__invoke($command);

    }
}
<?php
/**
 * Created by PhpStorm.
 * User: rosenstrauch
 * Date: 2/16/17
 * Time: 5:06 PM
 */

namespace spec\OpenCounter\Application\Command\Counter;

use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Repository\PersistentCounterRepository;
use OpenCounter\Http\CounterBuildService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use OpenCounter\Application\Command\Counter\CounterSetStatusCommand;
use OpenCounter\Application\Command\Counter\CounterSetStatusHandler;

class CounterSetStatusHandlerSpec extends ObjectBehavior
{
    function let(
      PersistentCounterRepository $repository,
      CounterBuildService $counterBuildService
    ) {
        $this->beConstructedWith($repository, $counterBuildService);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CounterSetStatusHandler::class);
    }

    function it_locks_a_counter(
      CounterSetStatusCommand $command,
      PersistentCounterRepository $repository,
      Counter $counter,
      CounterBuildService $counterBuildService
    ) {
        $command->status()->shouldBeCalled()->willReturn('locked');

        $command->name()->shouldBeCalled()->willReturn('Counter-name');

//            $counter = new CounterBuildService($repository,)
        $repository->getCounterByName(new CounterName('Counter-name'))
          ->shouldBeCalled()
          ->willReturn($counter);
//        $counter = $counterBuildService->execute($command)->shouldBeCalled()->willReturn($counter);

        $counter->lock()->shouldBeCalled();
        // TODO: after building a counter object we can have the repository save it.
        $repository->update($counter)->shouldBeCalled();

        $this->__invoke($command);

    }

    function it_unlocks_a_counter(
      CounterSetStatusCommand $command,
      PersistentCounterRepository $repository,
      Counter $counter,
      CounterBuildService $counterBuildService
    ) {
        $command->status()->shouldBeCalled()->willReturn('active');

        $command->name()->shouldBeCalled()->willReturn('Counter-name');

//            $counter = new CounterBuildService($repository,)
        $repository->getCounterByName(new CounterName('Counter-name'))
          ->shouldBeCalled()
          ->willReturn($counter);
//        $counter = $counterBuildService->execute($command)->shouldBeCalled()->willReturn($counter);

        $counter->enable()->shouldBeCalled();
        // TODO: after building a counter object we can have the repository save it.
        $repository->update($counter)->shouldBeCalled();

        $this->__invoke($command);

    }
}
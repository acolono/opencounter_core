<?php

namespace spec\OpenCounter\Application\Command\Counter;

use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Repository\PersistentCounterRepository;
use OpenCounter\Http\CounterBuildService;
use PhpSpec\ObjectBehavior;
use OpenCounter\Application\Command\Counter\CounterAddCommand;
use OpenCounter\Application\Command\Counter\CounterAddHandler;

class CounterAddHandlerSpec extends ObjectBehavior
{
    function let(
      PersistentCounterRepository $repository,
      CounterBuildService $counterBuildService
    ) {
        $this->beConstructedWith($repository, $counterBuildService);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CounterAddHandler::class);
    }

//    function it_does_not_add_if_counter_name_already_exists(
//        CounterAddCommand $command,
//        PersistentCounterRepository $repository,
//        Counter $counter,
//        CounterBuildService $counterBuildService
//    )
//    {
//
//        $command->name()->shouldBeCalled()->willReturn('existing-Counter-name');
//        $counterBuildService->execute($command)->shouldBeCalled()->willReturn($counter);
//        $this->shouldThrow(CounterAlreadyExistsException::class)->during__invoke($command);
//
//    }

    function it_builds_and_adds_a_counter(
      CounterAddCommand $command,
      PersistentCounterRepository $repository,
      Counter $counter,
      CounterBuildService $counterBuildService
    ) {
//        $command->name()->shouldBeCalled()->willReturn('Counter-name');
//        $command->value()->shouldBeCalled()->willReturn('1');

//            $counter = new CounterBuildService($repository,)

        $counter = $counterBuildService->execute($command)
          ->shouldBeCalled()
          ->willReturn($counter);
        // TODO: after building a counter object we can have the repository save it.
//        $repository->save($counter)->shouldBeCalled();

        $this->__invoke($command);

    }
}
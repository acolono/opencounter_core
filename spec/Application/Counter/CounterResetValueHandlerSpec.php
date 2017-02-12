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
use OpenCounter\Domain\Model\Counter\CounterValue;
use OpenCounter\Domain\Repository\CounterRepository;
use OpenCounter\Domain\Repository\PersistentCounterRepository;
use OpenCounter\Http\CounterBuildService;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use OpenCounter\Application\Command\Counter\CounterResetValueCommand;
use OpenCounter\Application\Command\Counter\CounterResetValueHandler;
use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;

class CounterResetValueHandlerSpec extends ObjectBehavior
{
    function let(PersistentCounterRepository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CounterResetValueHandler::class);
    }

    function it_does_not_reset_because_Counter_does_no_exist(
      CounterResetValueCommand $command,
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

    function it_resets_a_counter(
      CounterResetValueCommand $command,
      PersistentCounterRepository $repository,
      Counter $counter
    ) {

        $command->name()->shouldBeCalled()->willReturn('Counter-name');

//            $counter = new CounterBuildService($repository,)

        $repository->getCounterByName(new CounterName('Counter-name'))
          ->shouldBeCalled()
          ->willReturn($counter);

        $counter->resetValueTo(new CounterValue(0))->shouldBeCalled();

        $repository->update($counter)->shouldBeCalled();

        $this->__invoke($command);

    }
}
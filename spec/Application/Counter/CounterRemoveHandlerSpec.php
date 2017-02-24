<?php
/**
 * Created by PhpStorm.
 * Counter: rosenstrauch
 * Date: 2/16/17
 * Time: 4:09 PM
 */

namespace spec\OpenCounter\Application\Command\Counter;

use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Repository\CounterRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use OpenCounter\Application\Command\Counter\CounterRemoveHandler;
use OpenCounter\Application\Command\Counter\CounterRemoveCommand;
use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;

class CounterRemoveHandlerSpec extends ObjectBehavior
{
    function let(CounterRepository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CounterRemoveHandler::class);
    }

    function it_does_not_remove_because_Counter_does_no_exist(
      CounterRemoveCommand $command,
      CounterRepository $repository
    ) {
        $command->id()->shouldBeCalled()->willReturn('non-exist-Counter-id');
        $repository->getCounterById(new CounterId('non-exist-Counter-id'))
          ->shouldBeCalled()
          ->willReturn(null);

        $this->shouldThrow(CounterNotFoundException::class)
          ->during__invoke($command);
    }

    function it_removes_Counter(
      CounterRemoveCommand $command,
      CounterRepository $repository,
      Counter $Counter
    ) {
        $command->id()->shouldBeCalled()->willReturn('Counter-id');

        $repository->getCounterById(new CounterId('Counter-id'))
          ->shouldBeCalled()
          ->willReturn($Counter);
        $repository->remove($Counter)->shouldBeCalled();

        $this->__invoke($command);
    }
}
<?php
/**
 * Created by PhpStorm.
 * Counter: rosenstrauch
 * Date: 2/16/17
 * Time: 4:09 PM
 */

namespace spec\OpenCounter\Application\Command\Counter;

use OpenCounter\Application\Command\Counter\CounterRemoveCommand;
use OpenCounter\Application\Command\Counter\CounterRemoveHandler;
use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;
use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Repository\CounterRepository;
use PhpSpec\ObjectBehavior;

/**
 * Class CounterRemoveHandlerSpec
 * @package spec\OpenCounter\Application\Command\Counter
 */
class CounterRemoveHandlerSpec extends ObjectBehavior
{
    /**
     * @param \OpenCounter\Domain\Repository\CounterRepository|\PhpSpec\Wrapper\Collaborator $repository
     */
    function let(CounterRepository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CounterRemoveHandler::class);
    }

    /**
     * @param \OpenCounter\Application\Command\Counter\CounterRemoveCommand|\PhpSpec\Wrapper\Collaborator $command
     * @param \OpenCounter\Domain\Repository\CounterRepository|\PhpSpec\Wrapper\Collaborator              $repository
     */
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

    /**
     * @param \OpenCounter\Application\Command\Counter\CounterRemoveCommand|\PhpSpec\Wrapper\Collaborator $command
     * @param \OpenCounter\Domain\Repository\CounterRepository|\PhpSpec\Wrapper\Collaborator              $repository
     * @param \OpenCounter\Domain\Model\Counter\Counter|\PhpSpec\Wrapper\Collaborator                     $Counter
     */
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

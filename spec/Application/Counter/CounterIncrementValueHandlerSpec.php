<?php
/**
 * Created by PhpStorm.
 * Counter: rosenstrauch
 * Date: 2/16/17
 * Time: 5:06 PM
 */

namespace spec\OpenCounter\Application\Command\Counter;

use OpenCounter\Application\Command\Counter\CounterIncrementValueCommand;
use OpenCounter\Application\Command\Counter\CounterIncrementValueHandler;
use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;
use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Model\Counter\CounterValue;
use OpenCounter\Domain\Repository\PersistentCounterRepository;
use PhpSpec\ObjectBehavior;

/**
 * Class CounterIncrementValueHandlerSpec
 * @package spec\OpenCounter\Application\Command\Counter
 */
class CounterIncrementValueHandlerSpec extends ObjectBehavior
{
    /**
     * @param \OpenCounter\Domain\Repository\PersistentCounterRepository|\PhpSpec\Wrapper\Collaborator $repository
     */
    function let(PersistentCounterRepository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CounterIncrementValueHandler::class);
    }

    /**
     * @param \OpenCounter\Application\Command\Counter\CounterIncrementValueCommand|\PhpSpec\Wrapper\Collaborator $command
     * @param \OpenCounter\Domain\Repository\PersistentCounterRepository|\PhpSpec\Wrapper\Collaborator            $repository
     */
    function it_does_not_increment_because_Counter_does_no_exist(
        CounterIncrementValueCommand $command,
        PersistentCounterRepository $repository
    ) {
        $command->id()
          ->shouldBeCalled()
          ->willReturn('non-exist-Counter-id');
        $repository->getCounterById(new CounterId('non-exist-Counter-id'))
          ->shouldBeCalled()
          ->willReturn(null);

        $this->shouldThrow(CounterNotFoundException::class)
          ->during__invoke($command);
    }

    /**
     * @param \OpenCounter\Application\Command\Counter\CounterIncrementValueCommand|\PhpSpec\Wrapper\Collaborator $command
     * @param \OpenCounter\Domain\Repository\PersistentCounterRepository|\PhpSpec\Wrapper\Collaborator            $repository
     * @param \OpenCounter\Domain\Model\Counter\Counter|\PhpSpec\Wrapper\Collaborator                             $counter
     */
    function it_increments_a_counter(
        CounterIncrementValueCommand $command,
        PersistentCounterRepository $repository,
        Counter $counter
    ) {

        $command->id()->shouldBeCalled()->willReturn('Counter-id');
        $command->value()->shouldBeCalled()->willReturn('1');

        $repository->getCounterById(new CounterId('Counter-id'))
          ->shouldBeCalled()
          ->willReturn($counter);

        $counter->increaseCount(new CounterValue($command->value()
          ->shouldBeCalled()));

        $repository->update($counter)->shouldBeCalled();

        $this->__invoke($command);
    }
}

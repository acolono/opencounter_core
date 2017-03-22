<?php
/**
 * Created by PhpStorm.
 * User: rosenstrauch
 * Date: 2/16/17
 * Time: 5:06 PM
 */

namespace spec\OpenCounter\Application\Command\Counter;

use OpenCounter\Application\Command\Counter\CounterSetStatusCommand;
use OpenCounter\Application\Command\Counter\CounterSetStatusHandler;
use OpenCounter\Application\Service\Counter\CounterBuildService;
use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Repository\PersistentCounterRepository;
use PhpSpec\ObjectBehavior;

/**
 * Class CounterSetStatusHandlerSpec
 * @package spec\OpenCounter\Application\Command\Counter
 */
class CounterSetStatusHandlerSpec extends ObjectBehavior
{
    /**
     * @param \OpenCounter\Domain\Repository\PersistentCounterRepository|\PhpSpec\Wrapper\Collaborator   $repository
     * @param \OpenCounter\Application\Service\Counter\CounterBuildService|\PhpSpec\Wrapper\Collaborator $counterBuildService
     */
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

    /**
     * @param \OpenCounter\Application\Command\Counter\CounterSetStatusCommand|\PhpSpec\Wrapper\Collaborator $command
     * @param \OpenCounter\Domain\Repository\PersistentCounterRepository|\PhpSpec\Wrapper\Collaborator       $repository
     * @param \OpenCounter\Domain\Model\Counter\Counter|\PhpSpec\Wrapper\Collaborator                        $counter
     * @param \OpenCounter\Application\Service\Counter\CounterBuildService|\PhpSpec\Wrapper\Collaborator     $counterBuildService
     */
    function it_locks_a_counter(
        CounterSetStatusCommand $command,
        PersistentCounterRepository $repository,
        Counter $counter
    ) {
        $command->status()->shouldBeCalled()->willReturn('locked');

        $command->id()->shouldBeCalled()->willReturn('Counter-id');

        $repository->getCounterById(new CounterId('Counter-id'))
          ->shouldBeCalled()
          ->willReturn($counter);

        $counter->lock()->shouldBeCalled();
        // TODO: after building a counter object we can have the repository save it.
        $repository->save($counter)->shouldBeCalled();

        $this->__invoke($command);
    }

    /**
     * @param \OpenCounter\Application\Command\Counter\CounterSetStatusCommand|\PhpSpec\Wrapper\Collaborator $command
     * @param \OpenCounter\Domain\Repository\PersistentCounterRepository|\PhpSpec\Wrapper\Collaborator       $repository
     * @param \OpenCounter\Domain\Model\Counter\Counter|\PhpSpec\Wrapper\Collaborator                        $counter
     * @param \OpenCounter\Application\Service\Counter\CounterBuildService|\PhpSpec\Wrapper\Collaborator     $counterBuildService
     */
    function it_unlocks_a_counter(
        CounterSetStatusCommand $command,
        PersistentCounterRepository $repository,
        Counter $counter
    ) {
        $command->status()->shouldBeCalled()->willReturn('active');

        $command->id()->shouldBeCalled()->willReturn('Counter-id');

        $repository->getCounterById(new CounterId('Counter-id'))
          ->shouldBeCalled()
          ->willReturn($counter);

        $counter->enable()->shouldBeCalled();
        // TODO: after building a counter object we can have the repository save it.
        $repository->save($counter)->shouldBeCalled();

        $this->__invoke($command);
    }
}

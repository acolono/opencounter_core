<?php

namespace spec\OpenCounter\Application\Command\Counter;

use OpenCounter\Application\Command\Counter\CounterAddCommand;
use OpenCounter\Application\Command\Counter\CounterAddHandler;
use OpenCounter\Application\Service\Counter\CounterBuildService;
use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Repository\PersistentCounterRepository;
use PhpSpec\ObjectBehavior;

/**
 * Class CounterAddHandlerSpec
 * @package spec\OpenCounter\Application\Command\Counter
 */
class CounterAddHandlerSpec extends ObjectBehavior
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
        $this->shouldHaveType(CounterAddHandler::class);
    }

    /**
     * @param \OpenCounter\Application\Command\Counter\CounterAddCommand|\PhpSpec\Wrapper\Collaborator   $command
     * @param \OpenCounter\Domain\Repository\PersistentCounterRepository|\PhpSpec\Wrapper\Collaborator   $repository
     * @param \OpenCounter\Domain\Model\Counter\Counter|\PhpSpec\Wrapper\Collaborator                    $counter
     * @param \OpenCounter\Application\Service\Counter\CounterBuildService|\PhpSpec\Wrapper\Collaborator $counterBuildService
     */
    function it_builds_and_adds_a_counter(
        CounterAddCommand $command,
        PersistentCounterRepository $repository,
        Counter $counter,
        CounterBuildService $counterBuildService
    ) {

        $counter = $counterBuildService->execute($command)
          ->shouldBeCalled()
          ->willReturn($counter);

        $this->__invoke($command);
    }
}

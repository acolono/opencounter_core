<?php

/*
 * This file is part of the OpenCounter package.
 *
 * (c) Beñat Espiña <benatespina@gmail.com>
 * (c) Gorka Laucirica <gorka.lauzirika@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\OpenCounter\Application\Query\Counter;

use OpenCounter\Application\Query\Counter\CounterOfNameHandler;
use OpenCounter\Application\Query\Counter\CounterOfNameQuery;
use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;
use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Repository\CounterRepository;
use PhpSpec\ObjectBehavior;

/**
 * Class CounterOfNameHandlerSpec
 * @package spec\OpenCounter\Application\Query\Counter
 */
class CounterOfNameHandlerSpec extends ObjectBehavior
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
        $this->shouldHaveType(CounterOfNameHandler::class);
    }

    /**
     * @param \OpenCounter\Application\Query\Counter\CounterOfNameQuery|\PhpSpec\Wrapper\Collaborator $query
     * @param \OpenCounter\Domain\Repository\CounterRepository|\PhpSpec\Wrapper\Collaborator          $repository
     * @param \OpenCounter\Domain\Model\Counter\Counter|\PhpSpec\Wrapper\Collaborator                 $counter
     */
    function it_gets_the_counter(
        CounterOfNameQuery $query,
        CounterRepository $repository,
        Counter $counter
    ) {
        $query->name()->shouldBeCalled()->willReturn('counter-name');
        $name = new CounterName('counter-name');
        $repository->getCounterByName($name)
          ->shouldBeCalled()
          ->willReturn($counter);
        $this->__invoke($query)->shouldReturn($counter);
    }

    /**
     * @param \OpenCounter\Domain\Repository\CounterRepository|\PhpSpec\Wrapper\Collaborator          $repository
     * @param \OpenCounter\Application\Query\Counter\CounterOfNameQuery|\PhpSpec\Wrapper\Collaborator $query
     */
    function it_does_not_get_the_counter_because_the_name_does_not_exist(
        CounterRepository $repository,
        CounterOfNameQuery $query
    ) {
        $query->name()->shouldBeCalled()->willReturn('counter-name');
        $name = new CounterName('counter-name');
        $repository->getCounterByName($name)
          ->shouldBeCalled()
          ->willReturn(null);
        $this->shouldThrow(CounterNotFoundException::class)
          ->during__invoke($query);
    }
}

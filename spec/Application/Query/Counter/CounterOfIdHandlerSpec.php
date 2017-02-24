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

use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Repository\CounterRepository;
use OpenCounter\Application\Query\Counter\CounterOfIdHandler;
use OpenCounter\Application\Query\Counter\CounterOfIdQuery;
use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;

use PhpSpec\ObjectBehavior;

class CounterOfIdHandlerSpec extends ObjectBehavior
{
    function let(CounterRepository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CounterOfIdHandler::class);
    }

    function it_gets_the_counter(
      CounterOfIdQuery $query,
      CounterRepository $repository,
      Counter $counter

    ) {
        $query->id()->shouldBeCalled()->willReturn('counter-id');
        $id = new CounterId('counter-id');
        $repository->getCounterById($id)
          ->shouldBeCalled()
          ->willReturn($counter);
        $this->__invoke($query)->shouldReturn($counter);
    }

    function it_does_not_get_the_counter_because_the_id_does_not_exist(
      CounterRepository $repository,
      CounterOfIdQuery $query
    ) {
        $query->id()->shouldBeCalled()->willReturn('non-existant-counter-id');
        $id = new CounterId('non-existant-counter-id');
        $repository->getCounterById($id)->shouldBeCalled()->willReturn(null);
        // TODO: make sure the error is thrown at the correct point
        $this->shouldThrow(CounterNotFoundException::class)
          ->during__invoke($query);
    }
}

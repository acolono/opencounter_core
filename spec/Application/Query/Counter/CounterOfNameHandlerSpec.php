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

use OpenCounter\Application\Query\Counter\CounterOfNameQuery;
use OpenCounter\Application\Query\Counter\CounterOfNameHandler;
use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;
use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Repository\CounterRepository;
use PhpSpec\ObjectBehavior;


class CounterOfNameHandlerSpec extends ObjectBehavior
{
    function let(CounterRepository $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CounterOfNameHandler::class);
    }

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

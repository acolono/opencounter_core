<?php

namespace spec\OpenCounter\Http;

use Monolog\Logger;
use OpenCounter\Domain\Repository\CounterRepository;
use OpenCounter\Infrastructure\Factory\Counter\CounterFactory;
use PhpSpec\ObjectBehavior;

/**
 * Class CounterBuildServiceSpec
 * @package spec\OpenCounter\Http
 */
class CounterBuildServiceSpec extends ObjectBehavior
{
    /**
     * @param \OpenCounter\Domain\Repository\CounterRepository|\PhpSpec\Wrapper\Collaborator           $counter_repository
     * @param \OpenCounter\Infrastructure\Factory\Counter\CounterFactory|\PhpSpec\Wrapper\Collaborator $counter_factory
     * @param \Monolog\Logger|\PhpSpec\Wrapper\Collaborator                                            $logger
     */

    function let(
        CounterRepository $counter_repository,
        CounterFactory $counter_factory,
        Logger $logger
    ) {

        $this->beConstructedWith(
            $counter_repository,
            $counter_factory,
            $logger
        );
    }
}
// TODO: describe how to use the buildservice to create new counters (and why to use the buildservice instead of the factory directly)

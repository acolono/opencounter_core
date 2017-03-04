<?php

namespace spec\OpenCounter\Infrastructure\Factory\Counter;

use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Model\Counter\CounterValue;
use PhpSpec\ObjectBehavior;

/**
 * Class CounterFactorySpec
 * @package spec\OpenCounter\Infrastructure\Factory\Counter
 */
class CounterFactorySpec extends ObjectBehavior
{
    function it_implements_counter_factory_interface()
    {
        $this->shouldHaveType('OpenCounter\Infrastructure\Factory\Counter\CounterFactory');
    }

    /**
     * @param \OpenCounter\Domain\Model\Counter\CounterId|\PhpSpec\Wrapper\Collaborator    $counterId
     * @param \OpenCounter\Domain\Model\Counter\CounterName|\PhpSpec\Wrapper\Collaborator  $name
     * @param \OpenCounter\Domain\Model\Counter\CounterValue|\PhpSpec\Wrapper\Collaborator $value
     */
    function it_builds(
        CounterId $counterId,
        CounterName $name,
        CounterValue $value
    ) {
        $this->build($counterId, $name, $value, 'active', 'password')
          ->shouldReturnAnInstanceOf('OpenCounter\Domain\Model\Counter\Counter');
    }
}

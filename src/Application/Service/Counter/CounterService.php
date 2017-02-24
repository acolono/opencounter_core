<?php

namespace OpenCounter\Application\Service\Counter;

use OpenCounter\Domain\Model\Counter\CounterRepository;

/**
 * Class CounterService
 * @package OpenCounter\Application\Service\Counter
 */
abstract class CounterService implements ApplicationService
{
    /**
     * @var \OpenCounter\Domain\Model\Counter\CounterRepository
     */
    protected $CounterRepository;

    /**
     * CounterService constructor.
     * @param \OpenCounter\Domain\Model\Counter\CounterRepository $CounterRepository
     */
    public function __construct(
        CounterRepository $CounterRepository
    ) {
        $this->CounterRepository = $CounterRepository;
    }
}

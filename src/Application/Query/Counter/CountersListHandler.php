<?php

namespace OpenCounter\Application\Query\Counter;

use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;
use OpenCounter\Domain\Repository\CounterRepository;

/**
 * Class CountersListHandler
 * @package OpenCounter\Application\Query\Counter
 */
class CountersListHandler
{
    /**
     * CounterRepository
     *
     * @var \OpenCounter\Domain\Repository\CounterRepository
     */
    protected $CounterRepository;

    /**
     * CountersListHandler constructor.
     *
     * @param \OpenCounter\Domain\Repository\CounterRepository $CounterRepository
     */
    public function __construct(
        CounterRepository $CounterRepository
    ) {
        $this->CounterRepository = $CounterRepository;
    }

    /**
     * __invoke
     *
     * @return mixed
     * @throws \OpenCounter\Domain\Exception\Counter\CounterNotFoundException
     */
    public function __invoke()
    {

        if (!$Counters = $this->CounterRepository->findAll()) {
            throw new CounterNotFoundException('No Counters not found');
        }

        return $Counters;
    }
}

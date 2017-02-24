<?php

namespace OpenCounter\Application\Command\Counter;

use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Repository\CounterRepository;

/**
 * Class CounterSetStatusHandler
 * @package OpenCounter\Application\Command\Counter
 */
class CounterSetStatusHandler
{
    /**
     * CounterRepository
     *
     * @var \OpenCounter\Domain\Repository\CounterRepository
     */
    protected $CounterRepository;

    /**
     * CounterSetStatusHandler constructor.
     *
     * @param \OpenCounter\Domain\Repository\CounterRepository $CounterRepository
     */
    public function __construct(
        CounterRepository $CounterRepository
    ) {
        $this->CounterRepository = $CounterRepository;
    }

    /**
     * Handles the given command.
     *
     *
     * @throws CounterNotFoundException when the counter name isnt found in the repo
     */
    public function __invoke(CounterSetStatusCommand $aCommand)
    {
        if (!$counter = $this->CounterRepository->getCounterById(new CounterId($aCommand->id()))) {
            throw new CounterNotFoundException('Counter not found');
        }
        if ($aCommand->status() == 'locked') {
            $counter->lock();
        }
        if ($aCommand->status() == 'active') {
            $counter->enable();
        }
        $this->CounterRepository->save($counter);
    }
}

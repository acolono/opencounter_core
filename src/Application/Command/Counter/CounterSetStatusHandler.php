<?php

namespace OpenCounter\Application\Command\Counter;

use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Repository\CounterRepository;
use OpenCounter\Domain\Repository\PersistentCounterRepository;

class CounterSetStatusHandler
{

    protected $CounterRepository;

    public function __construct(
      CounterRepository $CounterRepository
    ) {
        $this->CounterRepository = $CounterRepository;
    }

    /**
     * Handles the given command.
     *
     *
     * @throws CounterAlreadyExistException when the counter id is already exists
     */
    public function __invoke(CounterSetStatusCommand $aCommand)
    {
        if (!$counter = $this->CounterRepository->getCounterByName(new CounterName($aCommand->name()))) {
            throw new CounterNotFoundException();
        }
        if ($aCommand->status() == 'locked') {
            $counter->lock();
        }
        if ($aCommand->status() == 'active') {
            $counter->enable();
        }
        $this->CounterRepository->update($counter);
    }

}

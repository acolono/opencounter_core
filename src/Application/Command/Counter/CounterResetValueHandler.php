<?php
/**
 * Created by PhpStorm.
 * User: rosenstrauch
 * Date: 2/16/17
 * Time: 3:46 PM
 */

namespace OpenCounter\Application\Command\Counter;

use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Model\Counter\CounterValue;
use OpenCounter\Domain\Repository\CounterRepository;

class CounterResetValueHandler
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
    public function __invoke(CounterResetValueCommand $aCommand)
    {
        if (!$counter = $this->CounterRepository->getCounterByName(new CounterName($aCommand->name()))) {
            throw new CounterNotFoundException();
        }
        $counter->resetValueTo(new CounterValue(0));
        $this->CounterRepository->save($counter);
    }

}
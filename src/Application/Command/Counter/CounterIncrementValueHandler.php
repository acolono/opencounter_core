<?php
/**
 * Created by PhpStorm.
 * User: rosenstrauch
 * Date: 2/16/17
 * Time: 3:46 PM
 */

namespace OpenCounter\Application\Command\Counter;

use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Model\Counter\CounterValue;
use OpenCounter\Domain\Repository\CounterRepository;

/**
 * Class CounterIncrementValueHandler
 * @package OpenCounter\Application\Command\Counter
 */
class CounterIncrementValueHandler
{
    /**
     * CounterRepository
     *
     * @var \OpenCounter\Domain\Repository\CounterRepository
     */
    protected $CounterRepository;

    /**
     * CounterIncrementValueHandler constructor.
     *
     * @param \OpenCounter\Domain\Repository\CounterRepository $CounterRepository
     */
    public function __construct(
        CounterRepository $CounterRepository
    ) {
        $this->CounterRepository = $CounterRepository;
    }

    /**
     * Handles the given command
     *
     * Will get the counter and tell it to increment.
     *
     * @param \OpenCounter\Application\Command\Counter\CounterIncrementValueCommand $aCommand
     *
     * @throws \OpenCounter\Domain\Exception\Counter\CounterNotFoundException
     */
    public function __invoke(CounterIncrementValueCommand $aCommand)
    {
        if (!$counter = $this->CounterRepository->getCounterById(new CounterId($aCommand->id()))) {
            throw new CounterNotFoundException('Counter not found');
        }
        $counter->increaseCount(new CounterValue($aCommand->value()));
        $this->CounterRepository->save($counter);
    }
}

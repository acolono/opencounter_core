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
 * Class CounterResetValueHandler
 *
 * @package OpenCounter\Application\Command\Counter
 */
class CounterResetValueHandler
{
    /**
     * CounterRepository
     *
     * @var \OpenCounter\Domain\Repository\CounterRepository
     */
    protected $CounterRepository;

    /**
     * CounterResetValueHandler constructor.
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
     * will check if counter already exists before creating.
     *
     * @param \OpenCounter\Application\Command\Counter\CounterResetValueCommand $aCommand
     *
     * @throws \OpenCounter\Domain\Exception\Counter\CounterNotFoundException
     */
    public function __invoke(CounterResetValueCommand $aCommand)
    {
        if (!$counter = $this->CounterRepository->getCounterById(new CounterId($aCommand->id()))) {
            throw new CounterNotFoundException('Counter not found. You can not reset a counter that doesnt exist.');
        }
        $counter->resetValueTo(new CounterValue(0));
        $this->CounterRepository->save($counter);
    }
}

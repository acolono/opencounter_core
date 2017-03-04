<?php
/**
 * CounterSetStatusHandler
 *
 * Handler responsible for commands that lock and unlock counters.
 */
namespace OpenCounter\Application\Command\Counter;

use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;
use OpenCounter\Domain\Model\Counter\CounterId;
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
     * Handles the given command
     *
     * Will call handler corresponding to CounterSetStatusCommand
     * checks if it can find the counter and can set its statsu
     *
     * @param \OpenCounter\Application\Command\Counter\CounterSetStatusCommand $aCommand
     *
     * @throws \OpenCounter\Domain\Exception\Counter\CounterNotFoundException
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

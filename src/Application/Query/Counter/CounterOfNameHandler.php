<?php
/**
 * CounterOfNameHandler.php
 *
 * Handles Queries for counter by name
 */
namespace OpenCounter\Application\Query\Counter;

use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Repository\CounterRepository;

/**
 * Class CounterOfNameHandler
 *
 * @package OpenCounter\Application\Query\Counter
 */
class CounterOfNameHandler implements CounterQueryHandler
{
    /**
     * CounterOfNameHandler constructor.
     *
     * @param \OpenCounter\Domain\Repository\CounterRepository $CounterRepository
     */
    public function __construct(
        CounterRepository $CounterRepository
    ) {
        $this->CounterRepository = $CounterRepository;
    }

    /**
     * Invoke Counter Query
     *
     * try to return counter from repository or error.
     *
     * @param \OpenCounter\Application\Query\Counter\CounterQuery $aQuery
     *
     * @return mixed
     * @throws \OpenCounter\Domain\Exception\Counter\CounterNotFoundException
     */
    public function __invoke(CounterQuery $aQuery)
    {
        $CounterName = $aQuery->name();

        if (!$Counter = $this->CounterRepository->GetCounterByName(new CounterName($CounterName))) {
            throw new CounterNotFoundException('Counter not found');
        }

        return $Counter;
    }
}

<?php
/**
 * CounterOfIdHandler
 *
 * Handles counter of id queries.
 */
namespace OpenCounter\Application\Query\Counter;

use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Repository\CounterRepository;

/**
 * Class CounterOfIdHandler
 *
 * @package OpenCounter\Application\Query\Counter
 */
class CounterOfIdHandler implements CounterQueryHandler
{
    /**
     * CounterRepository
     *
     * @var \OpenCounter\Domain\Repository\CounterRepository
     */
    protected $CounterRepository;

    /**
     * CounterOfIdHandler constructor.
     *
     * @param \OpenCounter\Domain\Repository\CounterRepository $CounterRepository
     */
    public function __construct(
        CounterRepository $CounterRepository
    ) {
        $this->CounterRepository = $CounterRepository;
    }

    public function __invoke(CounterQuery $aQuery)
    {
        //        $userId = $request->userId();

        if (!$CounterId = $aQuery->id()) {
            throw new \InvalidArgumentException('ID cannot be null');
        }
//        $user = $this->userRepository->ofId(new UserId($userId));
//        if (null === $user) {
//            throw new UserDoesNotExistException();
//        }

        if (!$Counter = $this->CounterRepository->GetCounterById(new CounterId($CounterId))) {
            throw new CounterNotFoundException('Counter not found');
        }

//        if (!$Counter->userId()->equals(new UserId($userId))) {
//            throw new \InvalidArgumentException('User is not authorized to view this Counter');
//        }

        return $Counter;
    }
}

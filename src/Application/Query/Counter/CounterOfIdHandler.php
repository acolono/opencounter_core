<?php

namespace OpenCounter\Application\Query\Counter;

use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Repository\CounterRepository;

class CounterOfIdHandler
{
    protected $CounterRepository;

    public function __construct(
      CounterRepository $CounterRepository
    ) {
        $this->CounterRepository = $CounterRepository;
    }

    public function __invoke(CounterOfIdQuery $aQuery)
    {
        //        $userId = $request->userId();
        $CounterId = $aQuery->id();

//        $user = $this->userRepository->ofId(new UserId($userId));
//        if (null === $user) {
//            throw new UserDoesNotExistException();
//        }

        if (!$Counter = $this->CounterRepository->GetCounterById(new CounterId($CounterId))) {
            throw new CounterNotFoundException();
        }

//        if (!$Counter->userId()->equals(new UserId($userId))) {
//            throw new \InvalidArgumentException('User is not authorized to view this Counter');
//        }

        return $Counter;
    }
}

<?php

namespace OpenCounter\Application\Query\Counter;

use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Repository\CounterRepository;

class CounterOfNameHandler implements CounterQueryHandler
{
    public function __construct(
      CounterRepository $CounterRepository
    ) {
        $this->CounterRepository = $CounterRepository;
    }

    public function __invoke(CounterQuery $aQuery)
    {
        $CounterName = $aQuery->name();

        if (!$Counter = $this->CounterRepository->GetCounterByName(new CounterName($CounterName))) {
            throw new CounterNotFoundException('Counter not found');
        }

        return $Counter;

    }
}

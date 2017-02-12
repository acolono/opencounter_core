<?php

namespace OpenCounter\Application\Service\Counter;


use OpenCounter\Domain\Model\Counter\CounterRepository;

abstract class CounterService implements ApplicationService
{

    protected $CounterRepository;

    public function __construct(
      CounterRepository $CounterRepository
    ) {
        $this->CounterRepository = $CounterRepository;
    }
}

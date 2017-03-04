<?php
/**
 * Abstract CounterService
 *
 * Counter Application services can extend.
 */
namespace OpenCounter\Application\Service\Counter;

use OpenCounter\Domain\Repository\CounterRepository;

/**
 * Class CounterService
 * @package OpenCounter\Application\Service\Counter
 */
abstract class CounterService implements ApplicationService
{
    /**
     * CounterRepository
     *
     * @var \OpenCounter\Domain\Repository\CounterRepository
     */
    protected $CounterRepository;

    /**
     * CounterService constructor.
     *
     * @param \OpenCounter\Domain\Repository\CounterRepository $CounterRepository
     */
    public function __construct(
        CounterRepository $CounterRepository
    ) {
        $this->CounterRepository = $CounterRepository;
    }
}

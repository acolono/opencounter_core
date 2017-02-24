<?php
/**
 * Created by PhpStorm.
 * User: rosenstrauch
 * Date: 2/16/17
 * Time: 3:46 PM
 */

namespace OpenCounter\Application\Command\Counter;

use OpenCounter\Application\Service\Counter\CounterBuildService;
use OpenCounter\Domain\Exception\Counter\CounterAlreadyExistsException;
use OpenCounter\Domain\Repository\CounterRepository;

/**
 * Class CounterAddHandler
 * @package OpenCounter\Application\Command\Counter
 */
class CounterAddHandler
{
    /**
     * @var \OpenCounter\Domain\Repository\CounterRepository
     */
    protected $CounterRepository;
    /**
     * @var \OpenCounter\Application\Service\Counter\CounterBuildService
     */
    protected $counterBuildService;

    /**
     * CounterAddHandler constructor.
     * @param \OpenCounter\Domain\Repository\CounterRepository $CounterRepository
     * @param \OpenCounter\Application\Service\Counter\CounterBuildService $counterBuildService
     */
    public function __construct(
        CounterRepository $CounterRepository,
        CounterBuildService $counterBuildService
    ) {
        $this->CounterRepository = $CounterRepository;
        $this->counterBuildService = $counterBuildService;
    }

    /**
     * Handles the given command.
     *
     *
     * @throws CounterAlreadyExistException when the counter id is already exists
     */
    public function __invoke(CounterAddCommand $aCommand)
    {

        if (!$counter = $this->counterBuildService->execute($aCommand)) {
            throw new CounterAlreadyExistsException('Counter Already Exists');
        }

        $this->CounterRepository->save($counter);

        return $counter->toArray();
    }
}
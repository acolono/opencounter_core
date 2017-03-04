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
     * CounterRepository
     *
     * @var \OpenCounter\Domain\Repository\CounterRepository
     */
    protected $CounterRepository;
    /**
     * counterBuildService
     *
     * @var \OpenCounter\Application\Service\Counter\CounterBuildService
     */
    protected $counterBuildService;

    /**
     * CounterAddHandler constructor.
     *
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
     * Handles the given command
     *
     * Will check if counter already exists
     * then save the new counter if it doesnt.
     *
     * @param \OpenCounter\Application\Command\Counter\CounterAddCommand $aCommand
     *
     * @return array
     * @throws \OpenCounter\Domain\Exception\Counter\CounterAlreadyExistsException
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

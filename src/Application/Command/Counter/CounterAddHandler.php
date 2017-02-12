<?php
/**
 * Created by PhpStorm.
 * User: rosenstrauch
 * Date: 2/16/17
 * Time: 3:46 PM
 */

namespace OpenCounter\Application\Command\Counter;

use OpenCounter\Domain\Exception\Counter\CounterAlreadyExistsException;
use OpenCounter\Domain\Repository\CounterRepository;
use OpenCounter\Http\CounterBuildService;

class CounterAddHandler
{

    protected $CounterRepository;
    protected $counterBuildService;

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
            throw new CounterAlreadyExistsException();
        }

        $this->CounterRepository->save($counter);

        return $counter->toArray();
    }

}
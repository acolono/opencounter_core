<?php
/**
 * CounterRemoveHandler
 */
namespace OpenCounter\Application\Command\Counter;

use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Repository\CounterRepository;

/**
 * Class CounterRemoveHandler
 * @package OpenCounter\Application\Command\Counter
 */
class CounterRemoveHandler
{
    /**
     * CounterRepository
     *
     * @var \OpenCounter\Domain\Repository\CounterRepository
     */
    protected $CounterRepository;

    /**
     * CounterRemoveHandler constructor.
     * @param \OpenCounter\Domain\Repository\CounterRepository $CounterRepository
     */
    public function __construct(
        CounterRepository $CounterRepository
    ) {
        $this->CounterRepository = $CounterRepository;
    }

    /**
     * Invoke handler
     *
     * Handles Counter remove command
     *
     * @param \OpenCounter\Application\Command\Counter\CounterRemoveCommand $aCommand
     *
     * @throws \OpenCounter\Domain\Exception\Counter\CounterNotFoundException
     * {@inheritdoc}
     */
    public function __invoke(CounterRemoveCommand $aCommand)
    {
//        $userId = $request->userId();
        $counterId = $aCommand->id();
//        $user = $this->userRepository->ofId(new UserId($userId));
//        if (null === $user) {
//            throw new UserDoesNotExistException();
//        }

        $counter = $this->CounterRepository->getCounterById(new CounterId($counterId));
        if (!$counter) {
            throw new CounterNotFoundException('Counter not found');
        }

//        if (!$counter->userId()->equals(new UserId($userId))) {
//            throw new \InvalidArgumentException('User is not authorized to delete this counter');
//        }

        $this->CounterRepository->remove($counter);
    }
}

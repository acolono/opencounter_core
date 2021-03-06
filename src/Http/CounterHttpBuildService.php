<?php
/**
 * Used to create new counter objects from psr7 request.
 *
 * originally the build service was created so that it Calls build method on counter factory for us.
 * at the moment this is built to work with psr7 request objects containing the
 * values the counter will be created with as array in the request body
 *
 */

namespace OpenCounter\Http;

use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Exception\Counter\CounterAlreadyExistsException;

use OpenCounter\Domain\Repository\CounterRepository;
use OpenCounter\Infrastructure\Factory\Counter\CounterFactory;
use Psr\Log\LoggerInterface;

/**
 * Class CounterBuildService
 *
 * a service used to call our factory to create new counter objects
 *
 * @package OpenCounter\Http
 */
class CounterHttpBuildService
{
    /**
     * A Counter repository object
     * @var \OpenCounter\Domain\Repository\CounterRepository
     */
    private $counter_repository;
    /**
     * A Counter repository factory
     * @var \OpenCounter\Infrastructure\Factory\Counter\CounterFactory
     */
    private $counter_factory;
    /**
     * a logger.
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * CounterBuildService constructor.
     *
     * @param \OpenCounter\Domain\Repository\CounterRepository $counter_repository
     * @param \OpenCounter\Infrastructure\Factory\Counter\CounterFactory $counter_factory
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        CounterRepository $counter_repository,
        CounterFactory $counter_factory,
        LoggerInterface $logger
    ) {

        $this->counter_repository = $counter_repository;
        $this->counter_factory = $counter_factory;
        $this->logger = $logger;
    }


    /**
     * Execute Build service.
     *
     * @uses CounterFactory to create new counter objects
     * @param null $request
     *
     * @return mixed|\OpenCounter\Domain\Model\Counter\Counter
     * @throws \OpenCounter\Domain\Exception\Counter\CounterAlreadyExistsException
     *
     * @see https://leanpub.com/ddd-in-php/read#leanpub-auto-persisting-value-objects
     */
    public function execute($request = null)
    {

        //

        $counterId = $this->counter_repository->nextIdentity($request->id());

        $password = 'passwordplaceholder';
        try {
            $counter = $this->counter_repository->getCounterByName(new CounterName($request->name()));
        } catch (\Exception $e) {
            $return = ['message' => $e->getMessage()];
            $code = 409;
        }

        if (isset($counter) && $counter instanceof Counter) {
            throw new CounterAlreadyExistsException();
        }

        // Only the build service calls the factory to create counter objects.

        $counter = $this->counter_factory->build(
            $counterId,
            $request->name(),
            $request->value(),
            'active',
            $password
        );

        return $counter;
    }
}

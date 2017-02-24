<?php
/**
 * Used to create new counter objects from psr7 request.
 *
 * originally the build service was created so that it Calls build method on counter factory for us.
 * at the moment this is built to work with psr7 request objects containing the
 * values the counter will be created with as array in the request body
 *
 */

namespace OpenCounter\Application\Service\Counter;

use OpenCounter\Domain\Model\Counter\CounterValue;
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
class CounterBuildService
{
    /**
     * A Counter repository object
     *
     * @var \OpenCounter\Domain\Repository\CounterRepository
     */
    private $counter_repository;
    /**
     * A Counter repository factory
     *
     * @var \OpenCounter\Infrastructure\Factory\Counter\CounterFactory
     */
    private $counter_factory;
    /**
     * a logger.
     *
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
     *
     * @param  $args
     * @return mixed|Counter
     * @throws CounterAlreadyExistsException
     */
    public function execute($request = null)
    {

        // https://leanpub.com/ddd-in-php/read#leanpub-auto-persisting-value-objects
        // TODO: if an id was provided by the client then use that instead of setting a new one


        $counterId = $this->counter_repository->nextIdentity($request->id());

        $password = 'passwordplaceholder';
        $CounterName = new CounterName($request->name());
        $CounterValue = new CounterValue($request->value());
        try {
            $counter = $this->counter_repository->getCounterByName($CounterName);
        } catch (\Exception $e) {
            $error = ['message' => $e->getMessage()];
            return $error;
        }

        if (isset($counter) && $counter instanceof Counter) {
            throw new CounterAlreadyExistsException('A counter by that name already exists');
        }

        // Only the build service calls the factory to create counter objects.

        $counter = $this->counter_factory->build(
            $counterId,
            $CounterName,
            $CounterValue,
            'active',
            $password
        );

        return $counter;
    }
}

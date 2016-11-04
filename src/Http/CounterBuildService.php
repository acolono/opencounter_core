<?php

namespace OpenCounter\Http;

use OpenCounter\Domain\Model\Counter\CounterValue;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Exception\Counter\CounterAlreadyExistsException;
use Monolog\Logger;

use OpenCounter\Domain\Repository\CounterRepositoryInterface;
use OpenCounter\Infrastructure\Factory\Counter\CounterFactory;
use Psr\Http\Message\RequestInterface;
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

    private $counter_repository;
    private $counter_factory;
    private $logger;

    /**
     * @param CounterRepositoryInterface $counter_repository
     * @param CounterFactory             $counter_factory
     * @param LoggerInterface            $logger
     */
    public function __construct(
        CounterRepositoryInterface $counter_repository,
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
     * @param  RequestInterface|null $request
     * @param  $args
     * @return mixed|Counter
     * @throws CounterAlreadyExistsException
     */
    public function execute(RequestInterface $request = null, $args)
    {
        //    if (!$request instanceof SignInCounterRequest) {
        //      throw new \InvalidArgumentException('The request must be SignInCounterRequest instance');
        //    }
        $data = $request->getParsedBody();

        $this->logger->info(json_encode($data));

        // https://leanpub.com/ddd-in-php/read#leanpub-auto-persisting-value-objects

        $counterId = $this->counter_repository->nextIdentity();
        $name = new CounterName($args['name']);
        $value = new CounterValue((isset($args['value']) ? $args['value'] : 0));

        $password = 'passwordplaceholder';
        try {
            $counter = $this->counter_repository->getCounterByName($name);
        } catch (\Exception $e) {
            $return = ['message' => $e->getMessage()];
            $code = 409;
        }


        $this->logger->info('testing during creation if counter exists ');

        if (isset($counter) && $counter instanceof Counter) {
            throw new CounterAlreadyExistsException();
        }

        $counter = $this->counter_factory->build($counterId, $name, $value, 'active', $password);

        return $counter;
    }
}

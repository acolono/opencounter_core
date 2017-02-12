<?php
/**
 * Created by PhpStorm.
 * User: rosenstrauch
 * Date: 8/6/16
 * Time: 11:46 AM
 *
 * Contains Methods that receive requests, try to interact with counter objects
 * and counter repository and return a response.
 * each method writes to log during every step.
 * validation happens in the counter objects where exceptions are thrown and caught here
 */

namespace OpenCounter\Http;

use OpenCounter\Domain\Command\Counter\CounterRemoveCommand;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Model\Counter\CounterValue;

use OpenCounter\Domain\Repository\CounterRepository;

use OpenCounter\Domain\Service\Counter\CounterRemoveService;
use OpenCounter\Infrastructure\Persistence\StorageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

/**
 * Class CounterController
 *
 * @package OpenCounter\Api
 */
class CounterController
{
    /**
     * A Logger
     *
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;
    /**
     * CounterRepositoryInterface
     *
     * @var \OpenCounter\Domain\Repository\CounterRepository
     */
    private $counter_repository;
    /**
     * counterBuildService
     * @var \OpenCounter\Http\CounterBuildService
     */
    private $counterBuildService;

    /**
     * CounterController constructor.
     *
     * @param \Psr\Log\LoggerInterface $logger
     * @param \OpenCounter\Http\CounterBuildService $counterBuildService
     * @param \OpenCounter\Infrastructure\Persistence\StorageInterface $counter_mapper
     * @param \OpenCounter\Domain\Repository\CounterRepository $counter_repository
     */

    public function __construct(
        LoggerInterface $logger,
        CounterBuildService $counterBuildService,
        StorageInterface $counter_mapper,
        CounterRepository $counter_repository
    ) {

        $this->logger = $logger;
        $this->counterBuildService = $counterBuildService;
        $this->SqlManager = $counter_mapper;
        $this->counter_repository = $counter_repository;
    }

    /**
     * New Counter
     *
     * @param \Psr\Http\Message\RequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface|static
     */
    public function newCounter(
        RequestInterface $request,
        ResponseInterface $response,
        $args
    ) {

        try {

            $command = new \OpenCounter\Domain\Service\Counter\CounterAddService($this->counter_repository);
            $command->execute(
              new \OpenCounter\Domain\Command\Counter\CounterAddCommand($request->getParsedBody()));

        } catch (\Exception $e) {
            $return = json_encode($e->getMessage());
            $code = 409;
            $this->logger->info('exception ' . $e->getMessage());
        }

        $body = $response->getBody();
        $body->write($return);
        return $response->withStatus($code);
    }

    /**
     * addCounter.
     *
     * @SWG\Post(
     *     path="/counters",
     *     operationId="addCounter",
     *     description="Creates a new counter. Duplicates are allowed",
     *     tags={"docs"},
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="counter",
     *         in="body",
     *         description="Counter to add",
     *         required=true,
     *         @SWG\Schema(ref="#/definitions/counterInput"),
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="counter response",
     *         @SWG\Schema(ref="#/definitions/Counter")
     *     ),
     *     @SWG\Response(
     *         response="default",
     *         description="unexpected error",
     *         @SWG\Schema(ref="#/definitions/errorModel")
     *     )
     * )
     */
    public function addCounter()
    {
    }

    /**
     * incrementCounter
     *
     * try to increment a counter. will fail if counter is locked or not found.
     * if successful returns updated counter object in response
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *   request needs to contain an integer to increment by.
     * @param \Psr\Http\Message\ResponseInterface $response
     *   a response object to return
     * @param $args
     *   the name of the counter is passed as argument. note that increment value is passed in body though.
     * @return \Psr\Http\Message\ResponseInterface|static
     *   Either an exception if counter was locked or wasnt found or the updated counter object.
     */
    public function incrementCounter(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $args
    ) {

        $this->logger->info('incrementing (PATCH) counter with name ', $args);
        //we assume everything is going to fail
        $return = 'an error has occurred';
        $code = 400;

        try {
            $data = $request->getParsedBody();
            $this->logger->info('received request body', $data);
            $counterName = new CounterName($args['name']);
            $this->logger->info('check for existing counter ' . $counterName->name());
            $counter = $this->counter_repository->getCounterByName($counterName);
            $this->logger->info('attempt to increment counter');
            $increment = new CounterValue($data['value']);
            $update = $counter->increaseCount($increment);
            if ($update) {
                $this->counter_repository->update($counter);
                $return = json_encode($counter->toArray());
                $code = 201;
                $this->logger->info('updated counter', $counter->toArray());
            }
        } catch (\Exception $e) {
            $return = json_encode($e->getMessage());
            // TODO: get the return code from the exception?
            //      $code = 409;
            $this->logger->info('exception ' . $e->getMessage());
        }

        $body = $response->getBody();
        $body->write($return);
        return $response->withStatus($code);
    }

    /**
     * setCounterStatus
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface|static
     */
    public function setCounterStatus(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $args
    ) {
        $this->logger->info('updating (PATCH) status of counter ', $args);

        try {
            $data = $request->getParsedBody();
            $this->logger->info('received request data', $data);
            $counterName = new CounterName($args['name']);
            $counterValue = new CounterValue($data['value']);
            $counter = $this->counter_repository->getCounterByName($counterName);
            $counter->lock();
            $this->counter_repository->save($counter);
            $this->logger->info('saved locked counter', $counter->toArray());
            $return = json_encode($counter->toArray());
            $code = 201;
        } catch (\Exception $e) {
            $return = json_encode($e->getMessage());
            $code = 409;
            $this->logger->info('exception ' . $e->getMessage());
        }

        $body = $response->getBody();
        $body->write($return);
        return $response->withStatus($code);
    }

    /**
     * setCounter
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function setCounter(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $args
    ) {
        $this->logger->info('updating (PUT) counter with name ', $args);
        //we assume everything is going to fail
        $return = ['message' => 'an error has occurred'];
        $code = 400;

        try {
            $data = $request->getParsedBody();

            $this->logger->info('request', $data);
            $counterName = new CounterName($args['name']);
            $counterValue = new CounterValue($data['value']);
            $this->logger->info('find ' . $counterName->name());
            $counter = $this->counter_repository->getCounterByName($counterName);

            $this->logger->info('resetting ', $counter->toArray());
            $counter->resetValueTo($counterValue);
            $this->logger->info('saving ', $counter->toArray());

            $this->counter_repository->save($counter);

            $this->logger->info('return counter ', $counter->toArray());
            $return = $counter->toArray();
            $code = 201;
        } catch (\Exception $e) {
            $return = json_encode($e->getMessage());
            //      $code = 409;
            $this->logger->info('exception ' . $e->getMessage());
        }

        $body = $response->getBody();
        // now how can we allow slim response to write to body like this? and how to handle mimetypes

        $body->write(json_encode($return, JSON_UNESCAPED_SLASHES));
        return $response;
    }

    /**
     * getCount
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface|static
     */
    public function getCount(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $args
    ) {

        $this->logger->info('getting value from counter with name: ' . $args['name']);

        try {
            $counterName = new CounterName($args['name']);
            $counter = $this->counter_repository->getCounterByName($counterName);
            $this->logger->info('found', $counter->toArray());
            // write counter to response body
            $body = $response->getBody();
            $body->write(json_encode($counter->getValue()));
        } catch (\Exception $e) {
            //$return = json_encode($e->getMessage());
            //      $code = 409;
            $this->logger->info('exception ' . $e->getMessage());
            return $response->withStatus(404);
        }

        return $response;
    }

    /**
     * getCounter
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getCounter(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $args
    ) {
        $this->logger->info('getting counter with name: ', $args);

        try {
            $counterName = new CounterName($args['name']);
            $counter = $this->counter_repository->getCounterByName($counterName);
            $this->logger->info(json_encode($counter));
            $this->logger->info('found');
            //            return $response->withJson($counter->toArray(), 200);
            $body = $response->getBody();
            $body->write(json_encode($counter->toArray()));
        } catch (\Exception $e) {
            $return = json_encode($e->getMessage());
            //      $code = 409;
            $this->logger->info('exception ' . $e->getMessage());
        }

        return $response;
    }

    /**
     * deleteCounter
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function deleteCounter(
        ServerRequestInterface $request,
        ResponseInterface $response,
        $args
    ) {

        try {
            $command = new \OpenCounter\Domain\Service\Counter\CounterRemoveService($this->counter_repository);
            $command->execute(
              new \OpenCounter\Domain\Command\Counter\CounterRemoveCommand($request->getParsedBody()['name']));




        } catch (\Exception $e) {
            // TODO: catch specific expected exceptions and provide helpful user
            // feedback in the response instead of the error message
            $return = json_encode($e->getMessage());
            //      $code = 409;
            $this->logger->info('exception ' . $e->getMessage());
        }

        $body = $response->getBody();
        // now how can we allow slim response to write to body like this?
        //TODO: figure out if we can use this controller with slim Response o
        $body->write(json_encode($return, JSON_UNESCAPED_SLASHES));
        return $response;
    }

    /**
     * allAction.
     *
     * @return array
     */

    public function allAction()
    {
        $counters = $this->get('counter_repository')->findAll();

        return ['counter' => $counters];
    }
    /********************************************************************************
     * Methods to satisfy Interop\Container\ContainerInterface
     *******************************************************************************/

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws ContainerValueNotFoundException  No entry was found for this identifier.
     * @throws ContainerException               Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get($id)
    {
        if (!$this->offsetExists($id)) {
            throw new ContainerValueNotFoundException(
                sprintf(
                    'Identifier "%s" is not defined.',
                    $id
                )
            );
        }
        try {
            return $this->offsetGet($id);
        } catch (\InvalidArgumentException $exception) {
            if ($this->exceptionThrownByContainer($exception)) {
                throw new SlimContainerException(
                    sprintf('Container error while retrieving "%s"', $id),
                    null,
                    $exception
                );
            } else {
                throw $exception;
            }
        }
    }

    /**
     * Tests whether an exception needs to be recast for compliance with Container-Interop.  This will be if the
     * exception was thrown by Pimple.
     *
     * @param \InvalidArgumentException $exception
     *
     * @return bool
     */
    private function exceptionThrownByContainer(
        \InvalidArgumentException $exception
    ) {

        $trace = $exception->getTrace()[0];

        return $trace['class'] === PimpleContainer::class && $trace['function'] === 'offsetGet';
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return boolean
     */
    public function has($id)
    {
        return $this->offsetExists($id);
    }
}

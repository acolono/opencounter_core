<?php
/**
 * Created by PhpStorm.
 * User: rosenstrauch
 * Date: 8/6/16
 * Time: 12:42 PM
 */

namespace spec\OpenCounter\Http;

use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;
use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Service\Counter\CounterRemoveService;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Model\Counter\CounterValue;
use OpenCounter\Domain\Repository\CounterRepositoryInterface;
use OpenCounter\Domain\Repository\PersistentCounterRepositoryInterface;
use OpenCounter\Http\CounterBuildService;
use OpenCounter\Infrastructure\Persistence\StorageInterface;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Class CounterControllerSpec
 * @package spec\OpenCounter\Http
 *
 * A controller to respond to requests
 * that is not getting the container passed to it
 * but inflects on dependencies to inject.
 */
class CounterControllerSpec extends ObjectBehavior
{
    private $logger;
    private $counter_repository;
    private $counterBuildService;
    private $counterRemoveService;

    function let(
      LoggerInterface $logger,
      CounterBuildService $counterBuildService,
      StorageInterface $counter_mapper,
      CounterRepositoryInterface $counter_repository,
      CounterRemoveService $counter_remove_service
    ) {
        $this->beConstructedWith(
          $logger,
          $counterBuildService,
          $counter_mapper,
          $counter_repository,
          $counter_remove_service
        );

    }

    function it_is_initializable()
    {
        $this->shouldHaveType('OpenCounter\Http\CounterController');

    }

    function its_remove_method_deletes_counters(
      ServerRequestInterface $request,
      ResponseInterface $response
    ) {
        // mock a counter we have
        $object = new Counter(new CounterId('1'), new CounterName('demo'),
          new CounterValue('1'), 'active', 'password');
        $this->counter_repository->getCounterByName('demo')
          ->willReturn($object);

        // which counter gets deleted is derived from the information in the body or from the path?
        $delete_request_path = '';
        $delete_request_body = array();
        $request->getParsedBody()->willReturn($delete_request_body);
        $request->getUri()->willReturn($delete_request_path);

        // mock a delete counter request to be passed to the Service when calling the deleteCounter Method

        // it will tell the delete counter service to execute the request.
        // this is a command that doesnt give feedback
        $this->deleteCounterService()->execute($request)->shouldBeCalled();

        // call the appropriate controller method
        $response = $this->deleteCounter($request, 1);
        $response->shouldBeAnInstanceOf('ResponseInterface');

        // ensure the appropriate counter was deleted
        // TODO: seperate spec for failed Service
    }
}
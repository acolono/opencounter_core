<?php
/**
 * Created by PhpStorm.
 * User: rosenstrauch
 * Date: 8/6/16
 * Time: 12:42 PM
 */

namespace spec\OpenCounter\Http;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use OpenCounter\Domain\Exception\Counter\CounterNotFoundException;
use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Model\Counter\CounterValue;
use OpenCounter\Domain\Repository\CounterRepositoryInterface;
use OpenCounter\Domain\Repository\PersistentCounterRepositoryInterface;
use OpenCounter\Http\CounterBuildService;
use OpenCounter\Infrastructure\Persistence\Sql\Repository\Counter\SqlCounterRepository;
use OpenCounter\Infrastructure\Persistence\Sql\Repository\Counter\SqlPersistentCounterRepository;

use OpenCounter\Infrastructure\Persistence\StorageInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

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

    function let(
        LoggerInterface $logger,
        CounterBuildService $counterBuildService,
        StorageInterface $counter_mapper,
        CounterRepositoryInterface $counter_repository
    )
    {
        $this->beConstructedWith(
            $logger,
            $counterBuildService,
            $counter_mapper,
            $counter_repository
        );

    }
//  function it_is_initializable(ContainerInterface $container)
//  {
//    $this->shouldHaveType('OpenCounter\Http\CounterController');
//
//  }
//  function it_shows_a_single_counter(
//    ContainerInterface $container,
//    PersistentCounterRepositoryInterface $repository,
//    Response $response
//  ) {
//
//    $settings = ['foo' => 'FOO', 'bar' => 'BAR'];
//    $app = new \Slim\App($settings);
//    $container = $app->getContainer();
//
//    $this->setContainer($container);
//    $this->repository = $repository;
//    $this->beConstructedWith(
//      $container,
//      $repository,
//      $logger
//    );
//    $this->repository->find(1)->willReturn('A counter');
//
//    $this->showAction(1)->shouldReturn($response);
//  }
//  function it_throws_an_exception_if_a_counter_doesnt_exist(CounterRepositoryInterface $repository)
//  {
//    $id = 99;
//    $repository->find($id)->willReturn(null);
//    $this
//      ->shouldThrow(new CounterNotFoundException(
//        sprintf('Counter [%s] cannot be found.', $id)
//      ))
//      ->duringFindAction(999)
//    ;
//  }
//

//  function it_receives_post_requests_from_counter_route(){
//    $this->newCounter();
//  }
    /**
     * it responds with a counter object to get requests if the counter is found
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     */
  function it_receives_get_requests_from_counter_route_asking_for_counter_by_name(ServerRequestInterface $request, ResponseInterface $response){

//      $args = array();
//      $args['name'] = 'COUNTER';
//      $args['value'] = 0;
//      $CounterID = new CounterId('testid');
//      $CounterName = new CounterName($args['name']);
//      $CounterValue = new CounterValue($args['value']);
//      //$request->withParsedBody($args);
//      $Counter = new Counter($CounterID, $CounterName, $CounterValue, 'active', 'passwordplaceholder');
//
////      $this->getCounter($request, $response, $args)->shouldReturn($response->withStatus($Counter->toArray(), 200));
//      $this->getCounter($request, $response, $args)->shouldReturn($response->withStatus(200));
//    $counter->shouldBeAnInstanceOf('OpenCounter\Domain\Model\Counter\Counter');
  }
//  function it_receives_patch_requests_from_counter_route_to_reset_counter(){}
//  function it_receives_patch_requests_from_counter_route_to_lock_counter(){}
//  function it_receives_put_requests_from_counter_route_to_increment_counter(){}
}
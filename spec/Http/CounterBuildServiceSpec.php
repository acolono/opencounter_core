<?php

namespace spec\OpenCounter\Http;

use GuzzleHttp\PrepareBodyMiddleware;
use GuzzleHttp\Psr7\Uri;
use Monolog\Logger;
use OpenCounter\Domain\Exception\Counter\CounterAlreadyExistsException;
use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Model\Counter\CounterValue;
use OpenCounter\Domain\Repository\CounterRepository;
use OpenCounter\http\CounterBuildService;
use OpenCounter\Infrastructure\Factory\Counter\CounterFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;

class CounterBuildServiceSpec extends ObjectBehavior
{
//    function it_is_initializable()
//    {
//        $this->shouldHaveType(CounterBuildService::class);
//    }
    function let(
      CounterRepository $counter_repository,

      CounterFactory $counter_factory,
      Logger $logger)
    {

        $this->beConstructedWith($counter_repository, $counter_factory, $logger);
    }

    /**
     * calling execute method with certain arguments to get back a counter object built through the counter factory
     *
     * @param ServerRequestInterface $request
     * @param CounterRepository $counter_repository
     * @param CounterFactory $counter_factory
     * @param Logger $logger
     */
    public function it_can_be_used_to_create_new_counters(
        ServerRequestInterface $request,
        CounterRepository $counter_repository,
        CounterFactory $counter_factory,
        Logger $logger
    )
    {
        // basic case where we just make sure we get back a counter if everything is good
//
//        $uri = new Uri();
//        $headers = array();
//        $body = fopen('php://temp', 'r+');
        $args = array();
        $args['name'] = 'COUNTER';
        $args['value'] = 0;
//
//        // the new id will be gotten from repository
//        //$id = $counter_repository->nextIdentity()->shouldBeCalled()->willReturn(new CounterId());
//
//        // will check if counter already exists in repo
////    $counter_repository->getCounterByName($args['name'])->shouldBeCalled()->willReturn(NULL);
        $CounterID = new CounterId('testid');
        $counter_repository->nextIdentity()->shouldBeCalled()->willReturn($CounterID);

        $CounterName = new CounterName($args['name']);
        $CounterValue = new CounterValue($args['value']);
        $request->withParsedBody($args);
        $Counter = new Counter($CounterID, $CounterName, $CounterValue, 'active', 'passwordplaceholder');
        $counter_factory->build($CounterID, $CounterName, $CounterValue, 'active', 'passwordplaceholder')->willReturn($Counter);

        $this->execute($request, $args)->shouldReturn($Counter);
    }

    public function it_throws_exception_if_counter_to_be_added_already_exists_in_repo(
        ServerRequestInterface $request,
        CounterRepository $counter_repository,
        CounterFactory $counter_factory,
        Logger $logger
    )
    {

        $args = array();
        $args['name'] = 'COUNTER';
        $args['value'] = 0;
//
//        // the new id will be gotten from repository
$counter_repository->nextIdentity()->shouldBeCalled()->willReturn(new CounterId());
//
//        // will check if counter already exists in repo
    $counter_repository->getCounterByName($args['name'])->
    shouldBeCalled()->willThrow(new CounterAlreadyExistsException());
        $this->execute($request, $args)->shouldReturn(NULL);
    }
}
// TODO: describe how to use the buildservice to create new counters (and why to use the buildservice instead of the factory directly)
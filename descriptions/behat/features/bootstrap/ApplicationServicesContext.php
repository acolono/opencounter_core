<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Model\Counter\CounterValue;

/**
 * Defines application features from the specific context.
 */
class ApplicationServicesContext implements Context, SnippetAcceptingContext
{

    /**
     * @var bool
     */
    private $error;
    private $counter_repository;
    private $counter_factory;
    private $counterBuildService;
    private $logger;
    private $counter;
    private $counters;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        // in reality we will get the builder from container
        $this->logger = new \Monolog\Logger('appservices behat');
        $this->counter_factory = new \OpenCounter\Infrastructure\Factory\Counter\CounterFactory();
        // Note, using inmemory repo for testing domain layer, not actual db.
        // TODO: figure out a better place for these fixture thingies
        $this->counters = [];
        $this->counters[] = new Counter(
          new CounterId('1CE05088-ED1F-43E9-A415-3B3792655A9B'),
          new CounterName('abcounter'), new CounterValue(2), 'active',
          'passwordplaceholder'
        );
        $this->counters[] = new Counter(
          new CounterId('8CE05088-ED1F-43E9-A415-3B3792655A9B'),
          new CounterName('twocounter'), new CounterValue(2), 'active',
          'passwordplaceholder'
        );
        $this->counters[] = new Counter(
          new CounterId('62A0CEB4-0403-4AA6-A6CD-1EE808AD4D23'),
          new CounterName('test'), new CounterValue(0), 'locked',
          'passwordplaceholder'
        );
        $this->counters[] = new Counter(
          new CounterId('62A0CEB4-4575-4AA6-FD76-1EE808AD4D23'),
          new CounterName('3dcounter'), new CounterValue(1), 'disabled',
          'passwordplaceholder'
        );
        $this->counter_repository = new \OpenCounter\Infrastructure\Persistence\InMemory\Repository\Counter\InMemoryCounterRepository($this->counters);
        $this->counterBuildService = new \OpenCounter\Http\CounterBuildService(
          $this->counter_repository,
          $this->counter_factory,
          $this->logger
        );
    }

    /**
     * @Given a counter( with id) :id has been set
     */
    public function aCounterWithIdhasBeenSet($id)
    {
        $this->counterName = new CounterName('testcounter');
        $this->counterId = new CounterId($id);
        $this->counterValue = new CounterValue(0);

        // lets use the factory to create the counter here, but not bother with using the build Service
        // TODO we are not testing here just setting up a convinience function, could use this directly from domaincontext actually

        $this->counter = $this->counter_factory->build(
          $this->counterId,
          $this->counterName,
          $this->counterValue,
          'active',
          'passwordplaceholder');

    }

    /**
     * @Given a counter( with name) :name has been set
     */
    public function aCounterWithNamehasBeenSet($name)
    {
        $this->counterName = new CounterName($name);
        $this->counterId = new CounterId();
        $this->counterValue = new CounterValue(0);

        // lets use the factory to create the counter here, but not bother with using the build Service
        // TODO we are not testing here just setting up a convinience function, could use this directly from domaincontext actually
        $this->counter = $this->counter_factory->build(
          $this->counterId,
          $this->counterName,
          $this->counterValue,
          'active',
          'passwordplaceholder'
        );

    }

    /**
     * @Given a counter :name with a value of :value has been set
     */
    public function aCounterWithAValueOfWasAddedToTheCollection($name, $value)
    {
        $this->aCounterWithValueOfWasAddedToTheCollection(
          new CounterName($name),
          new CounterValue($value)
        );


    }

    /**
     * @Given a counter :name with a value of :value was added to the collection
     */
    public function aCounterWithValueOfWasAddedToTheCollection(
      $name,
      $value
    ) {

        $CounterAddService = new \OpenCounter\Application\Service\Counter\CounterAddService(
          new \OpenCounter\Application\Command\Counter\CounterAddHandler(
            $this->counter_repository,
            $this->counterBuildService
          )

        );

        $CounterAddService->execute(
          new \OpenCounter\Application\Command\Counter\CounterAddCommand(
            $name,
            $value,
            'active',
            'passwordplaceholder'
          )
        );

    }

    /**
     * @Then the value returned should be :arg1
     */
    public function theValueReturnedShouldBe($arg1)
    {
// TODO: move the typecasting somewhere else
        if (!(int)$arg1 === (int)$this->counter->getValue()) {
            throw new \Exception('value not equal');
        }
    }

    /**
     * @When I increment the value of the counter with ID :id
     */
//    public function iIncrementTheValueOfTheCounterWithId($id)
//    {
//        try {
////            $incremented = $this->counter->incrementValue();
//        } catch (Exception $e) {
//            $this->error = true;
//        }
//
//    }

    /**
     * @When I increment the value of the counter with name :name
     */
    public function iIncrementTheValueOfTheCounterWithName($name)
    {

        try {

            $CounterIncrementValueService = new \OpenCounter\Application\Service\Counter\CounterIncrementValueService(
              new \OpenCounter\Application\Command\Counter\CounterIncrementValueHandler(
                $this->counter_repository,
                $this->counterBuildService

              )
            );
            $CounterIncrementValueService->execute(
              new \OpenCounter\Application\Command\Counter\CounterIncrementValueCommand(
                $name,
                1
              )
            );

        } catch (Exception $e) {
            $this->error = true;
        }

    }

    /**
     * @When I lock the counter with ID :id
     */
//    public function iLockTheCounterWithId($id)
//    {
////        $this->counter->lock();
//    }

    /**
     * @When I lock the counter with Name :name
     */
    public function iLockTheCounterWithName($name)
    {

        $CounterSetStatusService = new \OpenCounter\Application\Service\Counter\CounterSetStatusService(
          new \OpenCounter\Application\Command\Counter\CounterSetStatusHandler(

          $this->counter_repository
        ));

        $CounterSetStatusService->execute(
          new \OpenCounter\Application\Command\Counter\CounterSetStatusCommand(
            $name,
            'locked'
          )
        );

//        $this->counter->lock();
    }

    /**
     * @Then I should see an error :message
     */
    public function iShouldSeeAnError($message)
    {
        if ($this->error !== true) {
            throw new \Exception('Error not found');
        }
    }

    /**
     * @When I (can )get the value of the counter with ID :arg1
     */
//    public function iGetTheValueOfTheCounterWithId($arg1)
//    {
////        $this->counter->getValue();
//    }

    /**
     * @When I (can )get the value of the counter with Name :name
     */
    public function iGetTheValueOfTheCounterWithName($name)
    {
        // first try without command bus dependency
        $CounterViewService = new \OpenCounter\Application\Service\Counter\CounterViewService(
          new \OpenCounter\Application\Query\Counter\CounterOfNameHandler(
            $this->counter_repository,
            $this->counterBuildService
          )

        );

        $this->counter = $CounterViewService->execute(
          new \OpenCounter\Application\Query\Counter\CounterOfNameQuery(
            $name
          )

        );

        $this->counter->getValue();

    }

    /**
     * @When I (can )reset the counter with Name :name
     */
    public function iResetTheCounterWithName($name)
    {

        // first try without command bus dependency
        $CounterResetValueService = new \OpenCounter\Application\Service\Counter\CounterResetValueService(
          new \OpenCounter\Application\Command\Counter\CounterResetValueHandler(
            $this->counter_repository
          )

        );

        $CounterResetValueService->execute(
          new \OpenCounter\Application\Command\Counter\CounterResetValueCommand(
            $name

          )
        );

    }

    /**
     * @When I set a counter with name :name
     */
    public function iSetACounterWithName($name)
    {

        // first try without command bus dependency
        $CounterAddService = new \OpenCounter\Application\Service\Counter\CounterAddService(
          new \OpenCounter\Application\Command\Counter\CounterAddHandler(
            $this->counter_repository,
            $this->counterBuildService
          )

        );

        $CounterAddService->execute(
          new \OpenCounter\Application\Command\Counter\CounterAddCommand(
            new CounterName($name),
            new CounterValue(0),
            'active',
            'passwordplaceholder'
          )
        );

    }

    /**
     * @Given no counter with id :id has been set
     */
    public function noCounterWithIdHasBeenSet($id)
    {
        $newCounterId = new CounterId($id);
        try {
            $this->counter = $this->counter_repository->getCounterById($newCounterId);
        } catch (Exception $e) {
            $this->error = true;
        }

        return $this->error;

    }

    /**
     * @Given no counter :name has been set
     */
    public function noCounterWithNameHasBeenSet($name)
    {
        $this->counterName = new CounterName($name);
        try {
            $this->counter = $this->counter_repository->getCounterByName($this->counterName);
        } catch (Exception $e) {
            $this->error = true;
        }

        return $this->error;

    }

    /**
     * @When I remove the counter with id :id
     */
    public function iRemoveTheCounterWithId($id)
    {
        try {

            $CounterRemoveService = new \OpenCounter\Application\Service\Counter\CounterRemoveService(new \OpenCounter\Application\Command\Counter\CounterRemoveHandler($this->counter_repository));

            $CounterRemoveService->execute(
              new \OpenCounter\Application\Command\Counter\CounterRemoveCommand($id)
            );

        } catch (Exception $e) {
            $this->error = true;
        }

        return $this->error;
    }

    /**
     * @When I remove the counter with name :name
     */
    public function iRemoveTheCounterWithName($name)
    {
        try {

            $CounterRemoveService = new \OpenCounter\Application\Service\Counter\CounterRemoveService(new \OpenCounter\Application\Command\Counter\CounterRemoveHandler($this->counter_repository));

            $CounterRemoveService->execute(
              new \OpenCounter\Application\Command\Counter\CounterRemoveCommand($name)
            );

//            $removed = $this->counter_repository->removeCounterByName($this->counterName);
        } catch (Exception $e) {
            $this->error = true;
        }

        return $this->error;
    }

}

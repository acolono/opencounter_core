<?php

namespace OpenCounter;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Monolog\Logger;
use OpenCounter\Application\Command\Counter\CounterAddCommand;
use OpenCounter\Application\Command\Counter\CounterAddHandler;
use OpenCounter\Application\Command\Counter\CounterIncrementValueCommand;
use OpenCounter\Application\Command\Counter\CounterIncrementValueHandler;
use OpenCounter\Application\Command\Counter\CounterRemoveCommand;
use OpenCounter\Application\Command\Counter\CounterRemoveHandler;
use OpenCounter\Application\Command\Counter\CounterResetValueCommand;
use OpenCounter\Application\Command\Counter\CounterResetValueHandler;
use OpenCounter\Application\Command\Counter\CounterSetStatusHandler;
use OpenCounter\Application\Query\Counter\CounterOfNameHandler;
use OpenCounter\Application\Query\Counter\CounterOfNameQuery;
use OpenCounter\Application\Query\Counter\CountersListHandler;
use OpenCounter\Application\Service\Counter\CounterAddService;
use OpenCounter\Application\Service\Counter\CounterBuildService;
use OpenCounter\Application\Service\Counter\CounterIncrementValueService;
use OpenCounter\Application\Service\Counter\CounterRemoveService;
use OpenCounter\Application\Service\Counter\CounterResetValueService;
use OpenCounter\Application\Service\Counter\CounterSetStatusService;
use OpenCounter\Application\Service\Counter\CountersListService;
use OpenCounter\Application\Service\Counter\CounterViewService;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Model\Counter\CounterValue;
use OpenCounter\Infrastructure\Factory\Counter\CounterFactory;
use OpenCounter\Infrastructure\Persistence\InMemory\Repository\Counter\InMemoryCounterRepository;

/**
 * Defines application features from the specific context.
 */
class ApplicationServicesContext implements Context, SnippetAcceptingContext
{

    use ContextUtilities;
    /**
     * @var bool
     */
    private $error;
    /**
     * @var \OpenCounter\Infrastructure\Persistence\InMemory\Repository\Counter\InMemoryCounterRepository
     */
    private $counter_repository;
    /**
     * @var \OpenCounter\Infrastructure\Factory\Counter\CounterFactory
     */
    private $counter_factory;
    /**
     * @var \OpenCounter\Application\Service\Counter\CounterBuildService
     */
    private $counterBuildService;
    /**
     * @var \Monolog\Logger
     */
    private $logger;
    /**
     * @var
     */
    private $counter;

    /**
     * @var
     */
    private $counterValue;
    /**
     * @var
     */
    private $counterId;
    /**
     * @var
     */
    private $counterName;
    /**
     * @var
     */
    private $allCounters;

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
        $this->logger = new Logger('appservices behat');
        $this->counter_factory = new CounterFactory();
        // Note, using inmemory repo for testing domain layer, not actual db.
        // TODO: figure out a better place for these fixture thingies
        $this->allCounters = [];

        $this->counter_repository = new InMemoryCounterRepository($this->allCounters);
        $this->counterBuildService = new CounterBuildService(
          $this->counter_repository,
          $this->counter_factory,
          $this->logger
        );
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
        $this->counter_repository->save($this->counter);
    }

    /**
     * @Given a counter :name with a value of :value has been set
     */
    public function aCounterWithAValueOfWasAddedToTheCollection($name, $value)
    {
        $this->aCounterWithValueOfWasAddedToTheCollection(
          $name,
          $value
        );

    }

    /**
     * @Given a counter :name with a value of :value was added to the collection
     */
    public function aCounterWithValueOfWasAddedToTheCollection(
      $name,
      $value
    ) {
        try {
            $CounterAddService = new CounterAddService(
              new CounterAddHandler(
                $this->counter_repository,
                $this->counterBuildService
              )

            );

            $CounterAddService->execute(
              new CounterAddCommand(
                $name,
                $value,
                'active',
                'passwordplaceholder'
              )
            );
        } catch (\Exception $e) {
            $this->error = true;
        }
    }

    /**
     * @Then the value returned should be :value
     */
    public function theValueReturnedShouldBe($value)
    {
// TODO: move the typecasting somewhere else
        if (!(int)$value === (int)$this->counter->getValue()) {
            throw new \Exception('value not equal');
        }
    }

    /**
     * @Then the Id returned should be :id
     */
    public function theIdReturnedShouldBe($id)
    {
// TODO: move the typecasting somewhere else
        if (!(int)$id === (int)$this->counter->getId()) {
            throw new \Exception('Id not equal');
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

            $CounterIncrementValueService = new CounterIncrementValueService(
              new CounterIncrementValueHandler(
                $this->counter_repository,
                $this->counterBuildService

              )
            );
            $CounterIncrementValueService->execute(
              new CounterIncrementValueCommand(
                $name,
                1
              )
            );

        } catch (\Exception $e) {
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
        try {
            $CounterSetStatusService = new CounterSetStatusService(
              new CounterSetStatusHandler(

                $this->counter_repository
              ));

            $CounterSetStatusService->execute(
              new CounterSetStatusCommand(
                $name,
                'locked'
              )
            );
        } catch (\Exception $e) {
            $this->error = true;
        }
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
    public function iGetTheValueOfTheCounterWithId($id)
    {
        try {
            // first try without command bus dependency
            $CounterViewService = new CounterViewService(
              new CounterOfIdHandler(
                $this->counter_repository,
                $this->counterBuildService
              )

            );

            $this->counter = $CounterViewService->execute(
              new CounterOfIdQuery(
                $id
              )

            );
        } catch (\Exception $e) {
            $this->error = true;
        }
    }

    /**
     * @When I (can )get the value of the counter with Name :name
     */
    public function iGetTheValueOfTheCounterWithName($name)
    {
        try {
            // first try without command bus dependency
            $CounterViewService = new CounterViewService(
              new CounterOfNameHandler(
                $this->counter_repository,
                $this->counterBuildService
              )

            );

            $this->counter = $CounterViewService->execute(
              new CounterOfNameQuery(
                $name
              )

            );
        } catch (\Exception $e) {
            $this->error = true;

            return $this->error;
        }

    }

    /**
     * @When I (can )reset the counter with Name :name
     */
    public function iResetTheCounterWithName($name)
    {
        try {
            $id = $this->iGetTheIdOfTheCounterWithName($name);

            // first try without command bus dependency
            $CounterResetValueService = new CounterResetValueService(
              new CounterResetValueHandler(
                $this->counter_repository
              )

            );

            $CounterResetValueService->execute(
              new CounterResetValueCommand(
                $id

              )
            );

        } catch (\Exception $e) {
            $this->error = true;
        }
    }

    /**
     * @When I (can )get the Id of the counter with Name :name
     */
    public function iGetTheIdOfTheCounterWithName($name)
    {
        try {
            // first try without command bus dependency
            $CounterViewService = new CounterViewService(
              new CounterOfNameHandler(
                $this->counter_repository,
                $this->counterBuildService
              )

            );

            $this->counter = $CounterViewService->execute(
              new CounterOfNameQuery(
                $name
              )

            );

            return $this->counter->getId();
        } catch (\Exception $e) {
            $this->error = true;
        }

    }

    /**
     * @When I set a counter with name :name
     */
    public function iSetACounterWithName($name)
    {
        try {
            // first try without command bus dependency
            $CounterAddService = new CounterAddService(
              new CounterAddHandler(
                $this->counter_repository,
                $this->counterBuildService
              )

            );

            $CounterAddService->execute(
              new CounterAddCommand(
                $name,
                0,
                'active',
                'passwordplaceholder'
              )
            );
        } catch (\Exception $e) {
            $this->error = true;

            return $this->error;
        }

    }

    /**
     * @Given no counter with id :id has been set
     */
    public function noCounterWithIdHasBeenSet($id)
    {
        $newCounterId = new CounterId($id);
        try {
            $this->counter = $this->counter_repository->getCounterById($newCounterId);
        } catch (\Exception $e) {
            $this->error = true;

            return $this->error;
        }

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

            return $this->error;
        }

    }

    /**
     * @When I remove the counter with id :id
     */
    public function iRemoveTheCounterWithId($id)
    {
        try {

            $CounterRemoveService = new CounterRemoveService(new CounterRemoveHandler($this->counter_repository));

            $CounterRemoveService->execute(
              new CounterRemoveCommand($id)
            );

        } catch (\Exception $e) {
            $this->error = true;

            return $this->error;
        }

    }

    /**
     * @When I remove the counter with name :name
     */
    public function iRemoveTheCounterWithName($name)
    {
        try {

            $CounterRemoveService = new CounterRemoveService(new CounterRemoveHandler($this->counter_repository));

            $CounterRemoveService->execute(
              new CounterRemoveCommand($name)
            );

        } catch (\Exception $e) {
            $this->error = true;

            return $this->error;
        }

    }

    /**
     * @When I list all counters
     */
    public function iListAllCounters()
    {
        try {

            $CountersListService = new CountersListService(new CountersListHandler($this->counter_repository));

            $this->allCounters = $CountersListService->execute();

        } catch (\Exception $e) {
            $this->error = true;

            return $this->error;
        }
    }

    /**
     * @Then I should see :amount counters
     */
    public function iShouldSeeCounters($amount)
    {
        $numberOfCounters = count($this->allCounters);
        if ($numberOfCounters != $amount) {

            throw new \Exception(sprintf('I expected %d but found %s counters',
              $amount, $numberOfCounters));
        }
    }
}

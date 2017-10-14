<?php
namespace OpenCounter;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Monolog\Logger;
use OpenCounter\Application\Service\Counter\CounterBuildService;
use OpenCounter\Domain\Exception\Counter\CounterAlreadyExistsException;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Model\Counter\CounterValue;
use OpenCounter\Infrastructure\Factory\Counter\CounterFactory;
use OpenCounter\Infrastructure\Persistence\InMemory\Repository\Counter\InMemoryCounterRepository;

/**
 * Defines application features from the specific context.
 */
class DomainContext implements Context, SnippetAcceptingContext
{
    use ContextUtilities;
    /**
     * @var bool
     */
    private $error;
    /**
     * @var \Monolog\Logger
     */
    private $logger;
    /**
     * @var \OpenCounter\Infrastructure\Factory\Counter\CounterFactory
     */
    private $counter_factory;
    /**
     * @var \OpenCounter\Infrastructure\Persistence\InMemory\Repository\Counter\InMemoryCounterRepository
     */
    private $counter_repository;
    /**
     * @var \OpenCounter\Application\Service\Counter\CounterBuildService
     */
    private $counterBuildService;
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
    private $counter;
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
        $this->logger = new Logger('domaincontext behat');
        $this->counter_factory = new CounterFactory();
        // Note, using inmemory repo for testing domain layer, not actual db.
        // TODO: figure out a better place for these fixture thingies
        $counters = [];

        $this->counter_repository = new InMemoryCounterRepository($counters);
        $this->counterBuildService = new CounterBuildService(
          $this->counter_repository,
          $this->counter_factory,
          $this->logger
        );
    }

    /** @BeforeScenario */
    public function gatherContexts(
      BeforeScenarioScope $scope
    ) {
        // we wanna reuse some domain context steps for convinience.
        // turns out that doesnt work as expected so i guess we
        // duplicate lower level functionality where we need it instead
        // of cascading contexts.
//        $environment = $scope->getEnvironment();
//
//        $this->ContextUtilities = $environment->getContext('ContextUtilities');

    }

    /**
     * @Given a counter :name with ID :id and a value of :value was added to the collection
     */
    public function aCounterWithIdAndAValueOfWasAddedToTheCollection(
      $name,
      $id,
      $value
    ) {
        $this->counterName = new CounterName($name);
        $this->counterId = new CounterId($id);
        $this->counterValue = new CounterValue($value);
        // lets use the factory to create the counter here, but not bother with using the build Service
        $this->counter = $this->counter_factory->build($this->counterId,
          $this->counterName, $this->counterValue, 'active',
          'passworplaceholder');
        $this->counter_repository->save($this->counter);

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
        $this->counter = $this->counter_factory->build($this->counterId,
          $this->counterName, $this->counterValue, 'active',
          'passwordplaceholder');
        $this->counter_repository->save($this->counter);

    }

    /**
     * @Given a counter( with name) :name has been set
     */
    public function aCounterWitrhNamehasBeenSet($name)
    {
        $this->counterName = new CounterName($name);
        $this->counterId = new CounterId();
        $this->counterValue = new CounterValue(0);

        // lets use the factory to create the counter here, but not bother with using the build Service
        $this->counter = $this->counter_factory->build($this->counterId,
          $this->counterName, $this->counterValue, 'active',
          'passwordplaceholder');
        $this->counter_repository->save($this->counter);

    }

    /**
     * @Given a counter :name with a value of :value has been set
     */
    public function aCounterWithAValueOfWasAddedToTheCollection($name, $value)
    {
        $this->counterName = new CounterName($name);
        $this->counterId = new CounterId();
        $this->counterValue = new CounterValue($value);
        // lets use the factory to create the counter here, but not bother with using the build Service
        $this->counter = $this->counter_factory->build($this->counterId,
          $this->counterName, $this->counterValue, 'active',
          'passwordplaceholder');
        $this->counter_repository->save($this->counter);

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
    public function iIncrementTheValueOfTheCounterWithId($id)
    {
        try {
            $incremented = $this->counter->increaseCount(new CounterValue(1));
        } catch (Exception $e) {
            $this->error = true;
        }
        $this->counter_repository->save($this->counter);

    }

    /**
     * @When I increment the value of the counter with name :name
     */
    public function iIncrementTheValueOfTheCounterWithName($name)
    {

        try {
            $increment = new CounterValue(1);
            $incremented = $this->counter->increaseCount($increment);
        } catch (Exception $e) {
            $this->error = true;
        }
        $this->counter_repository->save($this->counter);

    }

    /**
     * @When I lock the counter with ID :id
     */
    public function iLockTheCounterWithId($id)
    {
        $this->counter->lock();
    }

    /**
     * @When I lock the counter with Name :name
     */
    public function iLockTheCounterWithName($name)
    {
        $this->counter->lock();
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
    public function iGetTheValueOfTheCounterWithId($arg1)
    {
        $this->counter->getValue();
    }

    /**
     * @When I (can )get the value of the counter with Name :name
     */
    public function iGetTheValueOfTheCounterWithName($name)
    {
        // TODO: this should fail in case the counter wasnt set

        $this->counter->getValue();
    }

    /**
     * @When I reset the counter with ID :arg1
     */
    public function iResetTheCounterWithId($arg1)
    {
        // TODO: this should fail in case the counter wasnt set
        $this->counter->reset();
    }

    /**
     * @When I (can )reset the counter with Name :name
     */
    public function iResetTheCounterWithName($name)
    {
        try {
            if (!$this->counter) {
                throw new CounterNotFoundException();
            }
            $newValue = new CounterValue(0);
            $this->counter->resetValueTo($newValue);

        } catch (\Exception $e) {
            $this->error = true;

            return $this->error;
        }

    }

    /**
     * @When I set a counter with name :name
     */
    public function iSetACounterWithName($name)
    {
        // this should fail if counter with that name already exists
        // TODO: make sure Creating counter name object fails for invalid characters (validate value object creation!)
        $this->counterName = new CounterName($name);
        $this->noCounterWithNameHasBeenSet($name);

        $this->counterId = new CounterId('test');
        $this->counterValue = new CounterValue('0');
        $this->counter = $this->counter_factory->build(
          $this->counterId,
          $this->counterName,
          $this->counterValue,
          'active',
          'passworplaceholder'
        );

        // cannot save in memory repository since its not persistent, so not testing this?
        $this->counter_repository->save($this->counter);

    }

    /**
     * @Given no counter :name has been set
     */
    public function noCounterWithNameHasBeenSet($name)
    {
        $this->counterName = new CounterName($name);
        try {
            if ($this->counter = $this->counter_repository->getCounterByName($this->counterName)) {
                throw new CounterAlreadyExistsException();
            }
            // TODO: we need to throw an error if we have a result
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
            if ($this->counter = $this->counter_repository->getCounterById($newCounterId)) {
                throw new CounterAlreadyExistsException();
            }

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
            $CounterId = new CounterId($id);
            $removed = $this->counter_repository->removeCounterById($CounterId);
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
            $removed = $this->counter_repository->removeCounterByName($this->counterName);
        } catch (Exception $e) {
            $this->error = true;
        }

        return $this->error;
    }



    /**
     * @When I list all counters
     */
    public function iListAllCounters()
    {
        $this->allCounters = $this->counter_repository->getAllCounters();
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

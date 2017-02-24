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
class DomainContext implements Context, SnippetAcceptingContext
{

    /**
     * @var bool
     */
    private $error;

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
        $this->logger = new \Monolog\Logger('domaincontext behat');
        $this->counter_factory = new \OpenCounter\Infrastructure\Factory\Counter\CounterFactory();
        // Note, using inmemory repo for testing domain layer, not actual db.
        // TODO: figure out a better place for these fixture thingies
        $counters = [];
        $counters[] = new Counter(
          new CounterId('1CE05088-ED1F-43E9-A415-3B3792655A9B'),
          new CounterName('acounter'), new CounterValue(2), 'active',
          'passwordplaceholder'
        );
        $counters[] = new Counter(
          new CounterId('8CE05088-ED1F-43E9-A415-3B3792655A9B'),
          new CounterName('twocounter'), new CounterValue(2), 'active',
          'passwordplaceholder'
        );
        $counters[] = new Counter(
          new CounterId('62A0CEB4-0403-4AA6-A6CD-1EE808AD4D23'),
          new CounterName('test'), new CounterValue(0), 'locked',
          'passwordplaceholder'
        );
        $counters[] = new Counter(
          new CounterId('62A0CEB4-4575-4AA6-FD76-1EE808AD4D23'),
          new CounterName('bcounter'), new CounterValue(1), 'disabled',
          'passwordplaceholder'
        );
        $this->counter_repository = new \OpenCounter\Infrastructure\Persistence\InMemory\Repository\Counter\InMemoryCounterRepository($counters);
        $this->counterBuildService = new \OpenCounter\Application\Service\Counter\CounterBuildService(
          $this->counter_repository,
          $this->counter_factory,
          $this->logger
        );
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
                throw new \OpenCounter\Domain\Exception\Counter\CounterNotFoundException();
            }
            $newValue = new CounterValue(0);
            $this->counter->resetValueTo($newValue);

        } catch (Exception $e) {
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
//
//        if ($this->counter = $this->counter_repository->getCounterByName($this->counterName)) {
//            throw new \OpenCounter\Domain\Exception\Counter\CounterAlreadyExistsException();
//        }



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
     * @Given no counter with id :id has been set
     */
    public function noCounterWithIdHasBeenSet($id)
    {
        $newCounterId = new CounterId($id);
        try {
            if ($this->counter = $this->counter_repository->getCounterByName($newCounterId)) {
                throw new \OpenCounter\Domain\Exception\Counter\CounterAlreadyExistsException();
            }

        } catch (Exception $e) {
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
            if ($this->counter = $this->counter_repository->getCounterByName($this->counterName)) {
                throw new \OpenCounter\Domain\Exception\Counter\CounterAlreadyExistsException();
            }
            // TODO: we need to throw an error if we have a result
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

}

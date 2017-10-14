<?php

namespace OpenCounter;


use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Model\Counter\CounterValue;

/**
 * Defines application features to be reused.
 */
trait ContextUtilities
{

    public $counters;

    /**
     * @var \OpenCounter\Infrastructure\Factory\Counter\CounterFactory
     */
    private $counter_factory;

    /**
     * @var \OpenCounter\Domain\Repository\CounterRepository
     */
    private $counter_repository;

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
     * @Given there are :amount counters
     *
     * @param $amount
     */
    public function thereAreCounters($amount)
    {

        $iteration = $amount;
        while ($iteration > 0) {
            $counter = $this->generateRandomTestCounter();
            $this->counter_repository->save($counter);
            $this->counters[] = $counter;
            $iteration--;
        }

    }

    /**
     * Helper function that creates a counter object
     * TODO: consider using factory muffin instead of seeding manually so
     * seeding can be used for testing higher layers
     */
    public function generateRandomTestCounter()
    {
        //$randomchars = uniqid('testcounter');
        $randomchars = uniqid('aeioungirldst');

        $this->counterName = new CounterName(str_shuffle($randomchars));
        $this->counterId = $this->counter_repository->nextIdentity();
        $this->counterValue = new CounterValue(rand(5, 15));

        echo 'generating random counter';
        $aCounter = $this->counter_factory->build($this->counterId,
          $this->counterName, $this->counterValue, 'active',
          'passwordplaceholder');
        print_r($aCounter);

        return $aCounter;
    }

    /**
     *
     * Utility since we dont set counters with ids via service layer
     *
     * @Given a counter( with id) :id has been set
     *
     * @param $id
     */
    public function aCounterWithIdhasBeenSet($id)
    {
        $name = 'testname';
        $value = "1";
        $this->aCounterWithIdAndAValueOfWasAddedToTheCollection($name, $id,
          $value);
    }

    /**
     * adding counters with a specific id
     * isnt possible via the application layer.
     * instead this is just a utility to
     * create a counter with id for later test steps
     * and uses the domain context for it
     *
     * @Given a counter :name with ID :id and a value of :value was added to
     *   the collection
     */
    public function aCounterWithIdAndAValueOfWasAddedToTheCollection(
      $name,
      $id,
      $value
    ) {
        $this->counterName = new CounterName('testcounter');
        $this->counterId = new CounterId($id);
        $this->counterValue = new CounterValue(0);

        // lets use the factory to create the counter here, but not bother with using the build Service
        // TODO we are not testing here just setting up a convinience function,
        // could use this directly from domaincontext actually but there we arent saving the counter
        //$this->domainContext->aCounterWithIdhasBeenSet($id);

        $this->counter = $this->counter_factory->build(
          $this->counterId,
          $this->counterName,
          $this->counterValue,
          'active',
          'passwordplaceholder');
        $this->counter_repository->save($this->counter);
    }

}

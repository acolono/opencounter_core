<?php
/**
 * CounterRepositoryInterface.
 *
 * basic storage interface for saving and retrieving counters.
 */
namespace OpenCounter\Domain\Repository;

use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Model\Counter\CounterId;

/**
 * Interface CounterRepositoryInterface
 *
 * This class is between Entity layer(class Counter) and access object layer(interface Storage).
 *
 * Repository encapsulates the set of objects persisted in a data store and the operations performed over them
 * providing a more object-oriented view of the persistence layer
 *
 * Repository also supports the objective of achieving a clean separation and one-way dependency
 * between the domain and data mapping layers
 *
 * @package OpenCounter\Domain\Repository
 */
interface CounterRepository
{

    /**
     * Removes the counter given.
     *
     * @param \OpenCounter\Domain\Model\Counter\Counter $anCounter
     *   Counter object.
     *
     * @return mixed
     */
    public function remove(Counter $anCounter);

    /**
     * getCounterById
     *
     * @param \OpenCounter\Domain\Model\Counter\CounterId $anId
     *   Counter id.
     *
     * @return mixed
     */
    public function getCounterById(CounterId $anId);

    /**
     * getCounterByName
     *
     * @param \OpenCounter\Domain\Model\Counter\CounterName $aName
     *   Counter name.
     *
     * @return mixed
     */
    public function getCounterByName(CounterName $aName);

    /**
     * getCounterByUuid
     *
     * @param \OpenCounter\Domain\Model\Counter\CounterId $anId
     *   Counter Id.
     *
     * @return mixed
     */
    public function getCounterByUuid(CounterId $anId);

    /**
     * Gets the counter/counters that match with the given criteria.
     *
     * @param mixed $specification The specification criteria
     *   a specification criteria
     *
     * @return mixed
     */
    public function query($specification);

    /**
     * Returns the next available id.
     *
     * @return mixed
     */
    public function nextIdentity();

    /**
     * Counts the number of counters.
     *
     * @return mixed
     */
    public function size();

    //  public function find($argument1);
}

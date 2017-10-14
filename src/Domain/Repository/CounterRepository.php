<?php
/**
 * CounterRepositoryInterface.
 *
 * basic storage interface for saving and retrieving counters.
 */
namespace OpenCounter\Domain\Repository;

use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Model\Counter\CounterName;

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
   * remove a counter by name.
   *
   * @param \OpenCounter\Domain\Model\Counter\CounterName $aName
   *
   * @return mixed
   */
  public function removeCounterByName(CounterName $aName);

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
   * Returns the next available id.
   *
   * @param $id
   *
   * @return mixed
   */
  public function nextIdentity($id);

  /**
   * Counts the number of counters.
   *
   * @return mixed
   */
  public function size();

  //  public function find($argument1);

  /**
   * Saves the counter given.
   *
   * @param  \OpenCounter\Domain\Model\Counter\Counter $anCounter
   *
   * @return mixed
   */
  public function save(Counter $anCounter);

  public function getAllCounters();
}

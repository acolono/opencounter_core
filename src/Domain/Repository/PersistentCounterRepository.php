<?php
/**
 * PersistentCounterRepositoryInterface.
 *
 * Explains how counters can be saved to persistent storage.
 */
namespace OpenCounter\Domain\Repository;

use OpenCounter\Domain\Model\Counter\Counter;
use OpenCounter\Domain\Model\Counter\CounterName;

/**
 * Persistent repository has a few more methods for saving.
 *
 * Interface PersistentCounterRepositoryInterface
 *
 * @package OpenCounter\Domain\Repository
 */
interface PersistentCounterRepository extends CounterRepository
{
    /**
     * Saves the counter given.
     *
     * @param  \OpenCounter\Domain\Model\Counter\Counter $anCounter
     * @return mixed
     */
    public function save(Counter $anCounter);

    /**
     * insert a new counter.
     *
     * @param \OpenCounter\Domain\Model\Counter\Counter $anCounter
     *
     * @return mixed
     */
    public function insert(Counter $anCounter);

    /**
     * Update and existing counter.
     *
     * @param \OpenCounter\Domain\Model\Counter\Counter $anCounter
     *
     * @return mixed
     */
    public function update(Counter $anCounter);

    /**
     * remove a counter by name.
     *
     * @param \OpenCounter\Domain\Model\Counter\CounterName $aName
     *
     * @return mixed
     */
    public function removeCounterByName(CounterName $aName);

    /**
     * Checks that the counter given exists into database.
     *
     * @param \OpenCounter\Domain\Model\Counter\Counter $anCounter The counter
     *
     * @return bool
     */
    public function exist(Counter $anCounter);
    /**
     * Gets the counter/counters that match with the given criteria.
     *
     * @param mixed $specification The specification criteria
     *   a specification criteria
     *
     * @return mixed
     */
    public function query($specification);

}

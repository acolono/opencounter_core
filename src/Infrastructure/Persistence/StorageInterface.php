<?php
/**
 * Created by PhpStorm.
 * User: rosenstrauch
 * Date: 7/31/16
 * Time: 12:20 PM
 */

namespace OpenCounter\Infrastructure\Persistence;

/**
 * Interface Storage.
 *
 * This interface describes methods for accessing storage (not items in storage).
 * Concrete realization could be whatever we want - in memory, relational database, NoSQL database and etc
 */
interface StorageInterface
{

    /**
     * prepare
     *
     * @param $sql
     *
     * @return mixed
     */
    public function prepare($sql);

    /**
     * execute
     *
     * @param            $sql
     * @param array|null $parameters
     *
     * @return mixed
     */
    public function execute($sql, array $parameters = null);

    /**
     * transactional
     *
     * @param callable $callable
     *
     * @return mixed
     */
    public function transactional(callable $callable);
}

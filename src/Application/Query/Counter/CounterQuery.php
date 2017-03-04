<?php
/**
 * Created by PhpStorm.
 * User: rosenstrauch
 * Date: 2/18/17
 * Time: 5:45 PM
 */

namespace OpenCounter\Application\Query\Counter;

/**
 * Interface CounterQuery
 * @package OpenCounter\Application\Query\Counter
 */
interface CounterQuery
{
    /**
     * id of counter to query
     * @return mixed
     */
    public function id();

    /**
     * name of counter to get
     * @return mixed
     */
    public function name();
}

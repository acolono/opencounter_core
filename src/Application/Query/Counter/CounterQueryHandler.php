<?php
/**
 * Created by PhpStorm.
 * User: rosenstrauch
 * Date: 2/18/17
 * Time: 5:49 PM
 */

namespace OpenCounter\Application\Query\Counter;

/**
 * Interface CounterQueryHandler
 * @package OpenCounter\Application\Query\Counter
 */
interface CounterQueryHandler
{
    /**
     * invoke
     *
     * @param CounterQuery $request
     * @return mixed
     */
    public function __invoke(CounterQuery $request);
}

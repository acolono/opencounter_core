<?php

namespace OpenCounter\Application\Service\Counter;

use OpenCounter\Application\Query\Counter\CountersListHandler;

/**
 * Class CountersListService
 * @package OpenCounter\Application\Service\Counter
 */
class CountersListService implements ApplicationService
{
    /**
     * handler
     *
     * @var \OpenCounter\Application\Query\Counter\CountersListHandler
     */
    private $handler;

    /**
     * CountersListService constructor.
     *
     * @param \OpenCounter\Application\Query\Counter\CountersListHandler $aHandler
     */
    public function __construct(CountersListHandler $aHandler)
    {

        $this->handler = $aHandler;
    }

    /**
     * @param null $request
     *
     * @return mixed
     */
    public function execute($request = null)
    {
        // this service executes a query and therefore returns something
        return $this->handler->__invoke();
    }
}

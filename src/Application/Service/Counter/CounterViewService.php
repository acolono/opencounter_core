<?php

namespace OpenCounter\Application\Service\Counter;

use OpenCounter\Application\Query\Counter\CounterOfNameHandler;
use OpenCounter\Application\Query\Counter\CounterOfIdHandler;
use OpenCounter\Application\Query\Counter\CounterQueryHandler;

/**
 * Class CounterViewService
 * @package OpenCounter\Application\Service\Counter
 */
class CounterViewService extends CounterService
{

    /**
     * The command handler.
     *
     */
    private $handler;

    public function __construct(CounterQueryHandler $aHandler)
    {
        $this->handler = $aHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function execute($request = null)
    {
        // this service executes a query and therefore returns something
        return $this->handler->__invoke($request);
    }
}

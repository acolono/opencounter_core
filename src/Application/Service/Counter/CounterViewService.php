<?php

namespace OpenCounter\Application\Service\Counter;

use OpenCounter\Application\Command\Counter\CounterViewHandler;
use OpenCounter\Application\Query\Counter\CounterOfNameHandler;

class CounterViewService extends CounterService
{

    /**
     * The command handler.
     *
     */
    private $handler;

    public function __construct(CounterOfNameHandler $aHandler)
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

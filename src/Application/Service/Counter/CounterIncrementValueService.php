<?php

namespace OpenCounter\Application\Service\Counter;

use OpenCounter\Application\Command\Counter\CounterIncrementValueHandler;

class CounterIncrementValueService extends CounterService
{

    /**
     * The command handler.
     *
     */
    private $handler;

    /**
     * Constructor.
     *
     */
    public function __construct(CounterIncrementValueHandler $aHandler)
    {
        $this->handler = $aHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function execute($request = null)
    {
        $this->handler->__invoke($request);
    }

//
}

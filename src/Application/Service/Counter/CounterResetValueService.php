<?php

namespace OpenCounter\Application\Service\Counter;

use OpenCounter\Application\Command\Counter\CounterResetValueHandler;

class CounterResetValueService extends CounterService
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
    public function __construct(CounterResetValueHandler $aHandler)
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

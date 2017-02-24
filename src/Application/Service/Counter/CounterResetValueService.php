<?php

namespace OpenCounter\Application\Service\Counter;

use OpenCounter\Application\Command\Counter\CounterResetValueHandler;

/**
 * Class CounterResetValueService
 * @package OpenCounter\Application\Service\Counter
 */
class CounterResetValueService extends CounterService
{

    /**
     * The command handler
     *
     * @var \OpenCounter\Application\Command\Counter\CounterResetValueHandler
     */
    private $handler;

    /**
     * CounterResetValueService constructor.
     *
     * @param \OpenCounter\Application\Command\Counter\CounterResetValueHandler $aHandler
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

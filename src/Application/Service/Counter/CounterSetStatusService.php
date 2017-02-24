<?php

namespace OpenCounter\Application\Service\Counter;

use OpenCounter\Application\Command\Counter\CounterSetStatusHandler;

/**
 * Class CounterSetStatusService
 *
 * @package OpenCounter\Application\Service\Counter
 */
class CounterSetStatusService extends CounterService
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
    public function __construct(CounterSetStatusHandler $aHandler)
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
}

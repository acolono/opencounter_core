<?php
/**
 * Counter Set Status Application Service
 */
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
     * CounterSetStatusService constructor.
     *
     * @param \OpenCounter\Application\Command\Counter\CounterSetStatusHandler $aHandler
     */
    public function __construct(CounterSetStatusHandler $aHandler)
    {

        $this->handler = $aHandler;
    }

    /**
     * execute()
     *
     * invoke Handler to handle Command
     * {@inheritdoc}
     *
     * @param null $request
     */
    public function execute($request = null)
    {
        $this->handler->__invoke($request);
    }
}

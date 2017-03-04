<?php
/**
 * CounterIncrementValueService
 * executes commands via a handler in order to increment a counter
 */
namespace OpenCounter\Application\Service\Counter;

use OpenCounter\Application\Command\Counter\CounterIncrementValueHandler;

/**
 * Class CounterIncrementValueService
 * @package OpenCounter\Application\Service\Counter
 */
class CounterIncrementValueService extends CounterService
{

    /**
     * The command handler.
     *
     * @var \OpenCounter\Application\Command\Counter\CounterIncrementValueHandler
     */
    private $handler;

    /**
     * CounterIncrementValueService constructor.
     *
     * @param \OpenCounter\Application\Command\Counter\CounterIncrementValueHandler $aHandler
     */
    public function __construct(CounterIncrementValueHandler $aHandler)
    {
        $this->handler = $aHandler;
    }

    /**
     * execute()
     *
     * {@inheritdoc}
     * invoke CounterIncrementValueHandler
     * to handle CounterIncrementValueCommand
     *
     * @param null $request
     */
    public function execute($request = null)
    {


        $this->handler->__invoke($request);
    }

//
}

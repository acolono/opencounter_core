<?php
/**
 * CounterResetValueService
 *
 * Application Service for resetting a counters value to 0
 */
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
     * Execute()
     * handle Counter reset command
     *
     * @param null $request
     * {@inheritdoc}
     */
    public function execute($request = null)
    {
        $this->handler->__invoke($request);
    }

//
}

<?php
/**
 * CounterViewService
 *
 * Application service for Getting counters.
 */
namespace OpenCounter\Application\Service\Counter;

use OpenCounter\Application\Query\Counter\CounterQueryHandler;

/**
 * Class CounterViewService
 *
 * @package OpenCounter\Application\Service\Counter
 */
class CounterViewService extends CounterService
{

    /**
     * Query handler
     *
     * @var \OpenCounter\Application\Query\Counter\CounterQueryHandler
     */
    private $handler;

    /**
     * CounterViewService constructor.
     *
     * @param \OpenCounter\Application\Query\Counter\CounterQueryHandler $aHandler
     */
    public function __construct(CounterQueryHandler $aHandler)
    {
        $this->handler = $aHandler;
    }

    /**
     * Execute
     *
     * Will handle Counter queries.
     * {@inheritdoc}
     *
     * @param null $request
     *
     * @return mixed
     */
    public function execute($request = null)
    {
        // this service executes a query and therefore returns something
        return $this->handler->__invoke($request);
    }
}

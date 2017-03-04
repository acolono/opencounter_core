<?php
/**
 * Created by PhpStorm.
 * User: rosenstrauch
 * Date: 2/11/17
 * Time: 3:03 AM
 */

namespace OpenCounter\Application\Service\Counter;

use OpenCounter\Application\Command\Counter\CounterAddHandler;

/**
 * Class CounterAddService
 * @package OpenCounter\Application\Service\Counter
 */
class CounterAddService extends CounterService
{

    /**
     * The command handler.
     *
     * @var CounterAddHandler
     */
    private $handler;

    /**
     * Constructor.
     *
     * @param CounterAddHandler $aHandler The command handler
     */
    public function __construct(CounterAddHandler $aHandler)
    {
        $this->handler = $aHandler;
    }

    /**
     * Execute()
     *
     * {@inheritdoc}
     * @param null $request
     *
     * @return array
     */
    public function execute($request = null)
    {
        return $this->handler->__invoke($request);
    }
}

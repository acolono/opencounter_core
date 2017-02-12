<?php
/**
 * Created by PhpStorm.
 * User: rosenstrauch
 * Date: 2/11/17
 * Time: 3:03 AM
 */

namespace OpenCounter\Application\Service\Counter;

use OpenCounter\Application\Command\Counter\CounterAddHandler;

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
     * {@inheritdoc}
     */
    public function execute($request = null)
    {
        $this->handler->__invoke($request);
    }
}

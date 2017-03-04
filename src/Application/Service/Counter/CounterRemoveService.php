<?php
/**
 * Counter remove service
 *
 * Application service that handles counter removal
 */
namespace OpenCounter\Application\Service\Counter;

use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Repository\CounterRepository;
use OpenCounter\Application\Command\Counter\CounterRemoveCommand;
use OpenCounter\Application\Command\Counter\CounterRemoveHandler;

/**
 * Class CounterRemoveService
 * @package OpenCounter\Application\Service\Counter
 */
class CounterRemoveService extends CounterService
{

    /**
     * CounterRemoveHandler
     *
     * @var \OpenCounter\Application\Command\Counter\CounterRemoveHandler
     */
    private $handler;

    /**
     * CounterRemoveService constructor.
     *
     * @param \OpenCounter\Application\Command\Counter\CounterRemoveHandler $aHandler
     */
    public function __construct(CounterRemoveHandler $aHandler)
    {
        $this->handler = $aHandler;
    }

    /**
     * execute Counter remove command
     *
     * {@inheritdoc}
     * @param null $request
     */
    public function execute($request = null)
    {
        $this->handler->__invoke($request);
    }
}

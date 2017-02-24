<?php

namespace OpenCounter\Application\Service\Counter;

use OpenCounter\Domain\Model\Counter\CounterName;
use OpenCounter\Domain\Repository\CounterRepository;
use OpenCounter\Application\Command\Counter\CounterRemoveCommand;
use OpenCounter\Application\Command\Counter\CounterRemoveHandler;

class CounterRemoveService extends CounterService
{

    /**
     * The command handler.
     *
     */
    private $handler;

    /**
     * Constructor.
     *
     * @param WithConfirmationSignUpUserHandler $aHandler The command handler
     */
    public function __construct(CounterRemoveHandler $aHandler)
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

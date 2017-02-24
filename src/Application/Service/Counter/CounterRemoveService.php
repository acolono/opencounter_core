<?php

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
     * WithConfirmationSignUpUserHandler
     *
     * @var \OpenCounter\Application\Command\Counter\CounterRemoveHandler|\OpenCounter\Application\Service\Counter\WithConfirmationSignUpUserHandler
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

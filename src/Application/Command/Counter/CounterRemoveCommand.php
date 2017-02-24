<?php

namespace OpenCounter\Application\Command\Counter;

/**
 * Class CounterRemoveCommand
 * @package OpenCounter\Application\Command\Counter
 */
class CounterRemoveCommand
{

    /**
     * @var
     */
    private $id;

    /**
     * CounterRemoveCommand constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */

    public function id()
    {
        return $this->id;
    }
}

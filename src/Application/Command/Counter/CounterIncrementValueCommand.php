<?php

namespace OpenCounter\Application\Command\Counter;

/**
 * Class CounterIncrementValueCommand
 * @package OpenCounter\Application\Command\Counter
 */
class CounterIncrementValueCommand
{
    /**
     * CounterIncrementValueCommand constructor.
     * @param $id
     * @param $value
     */
    public function __construct($id, $value)
    {
        $this->id = $id;
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }
}

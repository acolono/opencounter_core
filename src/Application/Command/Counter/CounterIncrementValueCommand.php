<?php

namespace OpenCounter\Application\Command\Counter;

class CounterIncrementValueCommand
{

    public function __construct($id, $value)
    {
        $this->id = $id;
        $this->value = $value;
    }

    public function id()
    {
        return $this->id;
    }

    public function value()
    {
        return $this->value;
    }
}

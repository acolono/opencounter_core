<?php

namespace OpenCounter\Application\Command\Counter;

class CounterIncrementValueCommand
{

    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function name()
    {
        return $this->name;
    }

    public function value()
    {
        return $this->value;
    }
}

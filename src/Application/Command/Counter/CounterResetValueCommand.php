<?php

namespace OpenCounter\Application\Command\Counter;

class CounterResetValueCommand
{

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function name()
    {
        return $this->name;
    }

}

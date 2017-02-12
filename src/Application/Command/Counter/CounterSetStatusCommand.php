<?php

namespace OpenCounter\Application\Command\Counter;

class CounterSetStatusCommand
{
    private $name;

    private $status;

    public function __construct($name, $status)
    {
        $this->name = $name;
        $this->status = $status;
    }

    public function status()
    {
        return $this->status;
    }

    public function name()
    {
        return $this->name;
    }
}


<?php

namespace OpenCounter\Application\Command\Counter;

class CounterSetStatusCommand
{
    private $name;

    private $status;

    public function __construct($id, $status)
    {
        $this->id = $id;
        $this->status = $status;
    }

    public function status()
    {
        return $this->status;
    }

    public function id()
    {
        return $this->name;
    }
}


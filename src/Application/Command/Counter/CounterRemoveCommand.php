<?php

namespace OpenCounter\Application\Command\Counter;

class CounterRemoveCommand
{
    private $name;
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function id()
    {
        return $this->id;
    }
}

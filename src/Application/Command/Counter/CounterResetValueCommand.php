<?php

namespace OpenCounter\Application\Command\Counter;

class CounterResetValueCommand
{

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function id()
    {
        return $this->id;
    }

}

<?php

namespace OpenCounter\Application\Command\Counter;

class CounterResetValueCommand
{
    /**
     * CounterResetValueCommand constructor.
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

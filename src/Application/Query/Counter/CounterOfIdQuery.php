<?php

namespace OpenCounter\Application\Query\Counter;

class CounterOfIdQuery
{
    protected $id;

    public function __construct($id)
    {
        if (null === $id) {
            throw new \InvalidArgumentException('ID cannot be null');
        }
        $this->id = $id;
    }

    public function id()
    {
        return $this->id;
    }
}

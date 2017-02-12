<?php

namespace OpenCounter\Application\Query\Counter;

class CounterOfNameQuery
{

    protected $name;

    public function __construct($name)
    {
        if (null === $name) {
            throw new \InvalidArgumentException('Name cannot be null');
        }
        $this->name = $name;
    }

    public function name()
    {
        return $this->name;
    }
}

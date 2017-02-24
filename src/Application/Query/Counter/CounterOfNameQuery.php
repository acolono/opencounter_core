<?php

namespace OpenCounter\Application\Query\Counter;

/**
 * Class CounterOfNameQuery
 * @package OpenCounter\Application\Query\Counter
 */
class CounterOfNameQuery implements CounterQuery
{
    /**
     * @var
     */
    protected $name;

    /**
     * CounterOfNameQuery constructor.
     * @param $name
     */
    public function __construct($name)
    {
        if (null === $name) {
            throw new \InvalidArgumentException('Name cannot be null');
        }
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function name()
    {
        return $this->name;
    }
}

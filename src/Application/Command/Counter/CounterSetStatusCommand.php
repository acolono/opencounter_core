<?php

namespace OpenCounter\Application\Command\Counter;

/**
 * Class CounterSetStatusCommand
 * @package OpenCounter\Application\Command\Counter
 */
class CounterSetStatusCommand
{
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $status;

    /**
     * CounterSetStatusCommand constructor.
     * @param $id
     * @param $status
     */
    public function __construct($id, $status)
    {
        $this->id = $id;
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function id()
    {
        return $this->name;
    }
}

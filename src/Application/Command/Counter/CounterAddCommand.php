<?php

namespace OpenCounter\Application\Command\Counter;

/**
 * Class CounterAddCommand
 * @package OpenCounter\Application\Command\Counter
 */
class CounterAddCommand
{
    /**
     * @var
     */
    private $name;
    /**
     * @var
     */
    private $value;
    /**
     * @var
     */
    private $status;
    /**
     * @var
     */
    private $password;

    /**
     * CounterAddCommand constructor.
     * @param $name
     * @param $value
     * @param $status
     * @param $password
     */
    public function __construct($name, $value, $status, $password)
    {
        $this->name = $name;
        $this->value = $value;
        $this->status = $status;
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
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
    public function password()
    {
        return $this->password;
    }
}

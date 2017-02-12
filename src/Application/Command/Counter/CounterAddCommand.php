<?php

namespace OpenCounter\Application\Command\Counter;

class CounterAddCommand
{
    private $name;
    private $value;
    private $status;
    private $password;

    public function __construct($name, $value, $status, $password)
    {
        $this->name = $name;
        $this->value = $value;
        $this->status = $status;
        $this->password = $password;
    }

    public function name()
    {
        return $this->name;
    }

    public function value()
    {
        return $this->value;
    }

    public function status()
    {
        return $this->status;
    }

    public function password()
    {
        return $this->password;
    }
}

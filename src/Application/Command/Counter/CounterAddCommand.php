<?php

namespace OpenCounter\Application\Command\Counter;

/**
 * Class CounterAddCommand
 * @SWG\Definition(
 *   required={"name"},
 *
 * @SWG\ExternalDocumentation(
 *     description="find more info here",
 *     url="https://swagger.io/about"
 *   )
 * )
 * @package OpenCounter\Application\Command\Counter
 */
class CounterAddCommand
{
    /**
     * Id of counter to add
     *
     * @var string
     * @SWG\Property(example="1c9e760c-4ec1-434d-a70d-ee402f009e1c")
     */
    private $id;

    /**
     * Name of counter to add
     *
     * @var string
     * @SWG\Property(example="onecounter")
     */
    private $name;
    /**
     * Value to Initialize counter with
     *
     * @var int
     * @SWG\Property(example=0)
     */
    private $value;
    /**
     * Status to initialize new counter with
     *
     * @var string
     *
     * @SWG\Property(example="active")
     *
     */
    private $status;
    /**
     * Password to protect counter with.
     *
     * @var string
     * @SWG\Property(example="active")
     */
    private $password;

    /**
     * CounterAddCommand constructor.
     *
     * @param $name
     * @param $value
     * @param $status
     * @param $password
     */
    public function __construct($name, $value, $status, $password, $id = null)
    {
        $this->name = $name;
        $this->value = $value;
        $this->status = $status;
        $this->password = $password;
        $this->id = $id;
    }
    /**
     * @return mixed
     */
    public function id()
    {
        return $this->id;
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

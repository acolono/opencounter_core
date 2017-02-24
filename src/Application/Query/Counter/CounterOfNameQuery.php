<?php

namespace OpenCounter\Application\Query\Counter;

/**
 * Class CounterOfNameQuery
 * @SWG\Definition(
 *   required={"name"},
 *
 * @SWG\ExternalDocumentation(
 *     description="find more info here",
 *     url="https://swagger.io/about"
 *   )
 * )
 * @package OpenCounter\Application\Query\Counter
 */
class CounterOfNameQuery implements CounterQuery
{
    /**
     * Name of counter to set status of.
     *
     * @var string
     *
     * @SWG\Property(example="findcounter")
     */
    protected $name;

    /**
     * CounterOfNameQuery constructor.
     *
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

<?php

/**
 * Contains counter value object.
 *
 * this validates itsself and stores a positive integer.
 *
 */


namespace OpenCounter\Domain\Model\Counter;

use OpenCounter\Domain\Exception\Counter\InvalidNativeArgumentException;

/**
 * Class CounterValue.
 *
 * @SWG\Definition(
 * @SWG\ExternalDocumentation(
 *     description="find more info here",
 *     url="https://swagger.io/about"
 *   )
 * )
 * @package OpenCounter\Domain\Model\Counter
 */

class CounterValue
{

    /**
     * The counter value.
     *
     * @var int
     * @SWG\Property(example="+1")
     */
    private $value;

    /**
     * Constructor.
     *
     * Takes an integer and defaults to 0
     *
     * @param $value
     */
    public function __construct($value)
    {
        if (isset($value)) {
            $value = filter_var($value, FILTER_VALIDATE_INT);
            if (false === $value) {
                throw new InvalidNativeArgumentException($value, ['int']);
            }
            $this->value = $value;
        } else {
            // if we didnt get  a value passed then initialize default value to 0
            $this->value = 0;
        }
    }

    /**
     * Return Value integer property from CounterValue Object
     *
     * @return int
     */
    public function value()
    {
        return (int) $this->value;
    }
}

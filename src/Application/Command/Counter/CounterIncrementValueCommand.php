<?php
/**
 * CounterIncrementValueCommand
 *
 * Contains class used to create objects
 * representing the intent to increment a counter.
 */

namespace OpenCounter\Application\Command\Counter;

/**
 * Class CounterIncrementValueCommand
 *
 * @SWG\Definition(
 *   required={"id"},
 *
 * @SWG\ExternalDocumentation(
 *     description="find more info here",
 *     url="https://swagger.io/about"
 *   )
 * )
 * @package OpenCounter\Application\Command\Counter
 */
class CounterIncrementValueCommand
{
    /**
     * Id of counter to set status of.
     *
     * @var string
     * @SWG\Property(
     *     example="1ff4debe-6160-4201-93d1-568d5a50a886",
     *     default="1ff4debe-6160-4201-93d1-568d5a50a886"
     * )
     */
    private $id;
    /**
     * Value to increment by.
     *
     * @var int
     * @SWG\Property(
     *     example=1,
     *     default=1
     *     )
     */
    private $value;

    /**
     * CounterIncrementValueCommand constructor.
     *
     * @param $id
     * @param $value
     */
    public function __construct($id, $value)
    {
        $this->id = $id;
        $this->value = $value;
    }

    /**
     * Id of counter to increment.
     *
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Value to increment by
     *
     * @return int
     */
    public function value()
    {
        return $this->value;
    }
}

<?php
/**
 * CounterResetValueCommand
 *
 * Contains class used to create objects
 * reperesenting the intent to reset a counter.
 */
namespace OpenCounter\Application\Command\Counter;

/**
 * Class CounterResetValueCommand
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
class CounterResetValueCommand
{
    /**
     * Id of counter to set status of.
     *
     * @var string
     * @SWG\Property(example="1ff4debe-6160-4201-93d1-568d5a50a886")
     */
    private $id;
    /**
     * CounterResetValueCommand constructor.
     *
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Id of counter to reset.
     * @return string
     */
    public function id()
    {
        return $this->id;
    }
}

<?php
/**
 * CounterSetStatusCommand
 *
 * Contains a Class to create objects representing the intent
 * to change counter status to loced or active.
 */
namespace OpenCounter\Application\Command\Counter;

/**
 * Class CounterSetStatusCommand
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
class CounterSetStatusCommand
{
    /**
     * Id of counter to set status of.
     *
     * @var string
     * @SWG\Property(example="1ff4debe-6160-4201-93d1-568d5a50a886")
     */
    private $id;
    /**
     * Status to set counter to.
     *
     * @var string
     * @SWG\Property(example="locked")
     */
    private $status;

    /**
     * CounterSetStatusCommand constructor.
     *
     * @param $id
     * @param $status
     */
    public function __construct($id, $status)
    {
        $this->id = $id;
        $this->status = $status;
    }

    /**
     * status
     *
     * @return mixed
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * id
     *
     * @return mixed
     */
    public function id()
    {
        return $this->id;
    }
}

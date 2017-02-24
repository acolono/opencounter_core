<?php

namespace OpenCounter\Application\Command\Counter;

/**
 * Class CounterRemoveCommand
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
class CounterRemoveCommand
{

    /**
     * Id of counter to set status of.
     *
     * @var string
     * @SWG\Property(example="1ff4debe-6160-4201-93d1-568d5a50a886")
     */
    private $id;

    /**
     * CounterRemoveCommand constructor.
     *
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */

    public function id()
    {
        return $this->id;
    }
}

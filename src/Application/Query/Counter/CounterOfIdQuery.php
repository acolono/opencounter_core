<?php
/**
 * CounterOfIdQuery
 *
 * represents a query for a counter by id
 */
namespace OpenCounter\Application\Query\Counter;

/**
 * Class CounterOfIdQuery
 * @SWG\Definition(
 *   required={"id"},
 *
 * @SWG\ExternalDocumentation(
 *     description="find more info here",
 *     url="https://swagger.io/about"
 *   )
 * )
 * @package OpenCounter\Application\Query\Counter
 */
class CounterOfIdQuery implements CounterQuery
{
    /**
     * Id of counter to find.
     *
     * @var string
     *
     * @SWG\Property(example="1ff4debe-6160-4201-93d1-568d5a50a886")
     */
    protected $id;

    /**
     * CounterOfIdQuery constructor.
     *
     * @param $id
     */
    public function __construct($id)
    {
        if (null === $id) {
            throw new \InvalidArgumentException('ID cannot be null');
        }
        $this->id = $id;
    }

    /**
     * Id of Counter
     *
     * @return string
     */
    public function id()
    {
        return $this->id;
    }


    /**
     * satisfy interface
     *
     * no name required when looking up counter by name
     * @return null
     */
    public function name()
    {
        return null;
    }
}

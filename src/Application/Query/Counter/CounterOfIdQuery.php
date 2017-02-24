<?php
/**
 * CounterOfIdQuery
 *
 * represents a query for a counter by id
 */
namespace OpenCounter\Application\Query\Counter;

/**
 * Class CounterOfIdQuery
 * @package OpenCounter\Application\Query\Counter
 */
class CounterOfIdQuery implements CounterQuery
{
    protected $id;

    public function __construct($id)
    {
        if (null === $id) {
            throw new \InvalidArgumentException('ID cannot be null');
        }
        $this->id = $id;
    }

    public function id()
    {
        return $this->id;
    }
}

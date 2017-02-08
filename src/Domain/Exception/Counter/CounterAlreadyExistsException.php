<?php
/**
 * CounterAlreadyExistsException.
 *
 * to prevent duplicate counters we throw an exception.
 */
namespace OpenCounter\Domain\Exception\Counter;

/**
 * Class CounterAlreadyExistsException
 *
 * @package OpenCounter\Domain\Exception\Counter
 */
class CounterAlreadyExistsException extends \Exception
{
}

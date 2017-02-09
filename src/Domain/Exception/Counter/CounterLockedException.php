<?php
/**
 * CounterLockedException.
 *
 * we throw this if a locked counter is refusing a change.
 */
namespace OpenCounter\Domain\Exception\Counter;

/**
 * Class CounterLockedException
 *
 * @package OpenCounter\Domain\Exception\Counter
 */
class CounterLockedException extends \Exception
{
}

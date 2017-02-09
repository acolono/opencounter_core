<?php
/**
 * InvalidNativeArgumentException.
 *
 * Thrown when we couldnt validate counter value
 */
namespace OpenCounter\Domain\Exception\Counter;

/**
 * Class InvalidNativeArgumentException
 * @package OpenCounter\Domain\Exception\Counter
 */
class InvalidNativeArgumentException extends \InvalidArgumentException
{
  /**
   * InvalidNativeArgumentException constructor.
   * @param string $value
   * @param array $allowed_types
   */
    public function __construct($value, array $allowed_types)
    {
        $this->message = sprintf(
            'Argument "%s" is invalid. Allowed types for argument are "%s".',
            $value,
            implode(', ', $allowed_types)
        );
    }
}

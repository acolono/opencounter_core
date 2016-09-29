<?php
/**
 * @file
 */
namespace OpenCounter\Domain\Factory;

use OpenCounter\Domain\Model\Counter\CounterValue;
use OpenCounter\Domain\Model\Counter\CounterId;
use OpenCounter\Domain\Model\Counter\CounterName;

/**
 * Interface CounterFactoryInterface
 * @package Domain\Factory\Counter
 */

interface CounterFactoryInterface
{
    /**
     * Creation method that registers a new counter into domain.
     *
     * @param CounterId $anId
     * @param CounterName $aName
     * @param CounterValue $anValue
     * @param $status
     * @param $aPassword
     * @return mixed
     */
    public function build(CounterId $anId, CounterName $aName, CounterValue $anValue, $status, $aPassword);
}
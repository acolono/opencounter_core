<?php
/**
 * Created by PhpStorm.
 * User: rosenstrauch
 * Date: 2/16/17
 * Time: 5:04 PM
 */

namespace spec\OpenCounter\Application\Command\Counter;

use OpenCounter\Application\Command\Counter\CounterIncrementValueCommand;
use PhpSpec\ObjectBehavior;

/**
 * Class CounterIncrementValueCommandSpec
 * @package spec\OpenCounter\Application\Command\Counter
 */
class CounterIncrementValueCommandSpec extends ObjectBehavior
{

    function it_increments_a_counter_command()
    {
        $this->beConstructedWith('testcounter', '2');
        $this->shouldHaveType(CounterIncrementValueCommand::class);

        // TODO: id should exist at this point. $this->id()->shouldNotBe(null);
        $this->value()->shouldReturn('2');
    }
}

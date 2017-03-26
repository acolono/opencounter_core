<?php
/**
 * Created by PhpStorm.
 * User: rosenstrauch
 * Date: 2/16/17
 * Time: 5:04 PM
 */

namespace spec\OpenCounter\Application\Command\Counter;

use OpenCounter\Application\Command\Counter\CounterResetValueCommand;
use PhpSpec\ObjectBehavior;

/**
 * Class CounterResetValueCommandSpec
 * @package spec\OpenCounter\Application\Command\Counter
 */
class CounterResetValueCommandSpec extends ObjectBehavior
{

    function it_resets_a_counter_command()
    {
        $this->beConstructedWith('7777777');
        $this->shouldHaveType(CounterResetValueCommand::class);

        // TODO: id should exist at this point. $this->id()->shouldNotBe(null);
        $this->id()->shouldReturn('7777777');
    }
}

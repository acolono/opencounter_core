<?php
/**
 * Created by PhpStorm.
 * User: rosenstrauch
 * Date: 2/16/17
 * Time: 5:04 PM
 */

namespace spec\OpenCounter\Application\Command\Counter;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use OpenCounter\Application\Command\Counter\CounterResetValueCommand;

class CounterResetValueCommandSpec extends ObjectBehavior
{

    function it_resets_a_counter_command()
    {
        $this->beConstructedWith('testcounter');
        $this->shouldHaveType(CounterResetValueCommand::class);

        // TODO: id should exist at this point. $this->id()->shouldNotBe(null);
        $this->name()->shouldReturn('testcounter');
    }
}
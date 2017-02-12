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
use OpenCounter\Application\Command\Counter\CounterSetStatusCommand;

class CounterSetStatusCommandSpec extends ObjectBehavior
{

    // TODO: nonexistant

    function its_a_lock_counter_command()
    {
        $this->beConstructedWith('testcounter', 'lock');
        $this->shouldHaveType(CounterSetStatusCommand::class);

        // TODO: id should exist at this point. $this->id()->shouldNotBe(null);
        $this->status()->shouldReturn('lock');
    }

    function its_a_unlock_counter_command()
    {
        $this->beConstructedWith('testcounter', 'unlock');
        $this->shouldHaveType(CounterSetStatusCommand::class);

        // TODO: id should exist at this point. $this->id()->shouldNotBe(null);
        $this->status()->shouldReturn('unlock');
    }
}
<?php

namespace spec\OpenCounter\Domain\Model\Counter;

use OpenCounter\Domain\Exception\Counter\InvalidNativeArgumentException;
use OpenCounter\Domain\Model\Counter\CounterValue;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CounterValueSpec extends ObjectBehavior
{


    /**
     * pass it an integer and you can get it back
     */
    function its_value_can_be_returned()
    {
        $value = (int)1;

        $this->beConstructedWith($value);
        $this->value()->shouldReturn($value);
        $this->shouldHaveType('OpenCounter\Domain\Model\Counter\CounterValue');

    }

    function it_borks_if_its_created_with_string()
    {
        $value = (string) 'string1';
        $this->beConstructedWith($value);
        $allowed_types = array('int');
        $this->shouldThrow(new InvalidNativeArgumentException(
            '',
            $allowed_types
        ))->duringInstantiation();
    }
//    function it_borks_if_its_created_with_array(){
//        $value = array(1);
//        $allowed_types = array('int');
//
//        $this->beConstructedWith($value);
//
//        $this->shouldThrow(new InvalidNativeArgumentException(array(), $allowed_types))->duringInstantiation();
//    }

    function it_sets_value_to_zero_by_default(){
        $this->beConstructedWith(NULL);

        $this->value()->shouldReturn(0);
    }
}

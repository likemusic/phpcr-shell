<?php

namespace spec\PHPCR\Shell\Config;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('PHPCR\Shell\Config\Config');
    }

    function let()
    {
        $this->beConstructedWith(array(
            'foo' => 'bar',
            'bar' => array(
                'boo' => 'baz'
            ),
        ));
    }

    function it_should_be_able_to_access_data_values()
    {
        $this['foo']->shouldReturn('bar');
    }

    function it_should_be_able_to_access_nested_config()
    {
        $this['bar']['boo']->shouldReturn('baz');
    }
}

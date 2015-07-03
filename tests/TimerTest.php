<?php

require 'src/Timer.php';

class TimerTest extends PHPUnit_Framework_TestCase {

    public function testTimerIsSet()
    {
        $timer = new \Myth\Timer\Timer();

        $timer->start('test');

        $t = $timer->get('test');

        $this->assertTrue($t['running']);
        $this->assertEquals(0.0, $t['stop_time']);
        $this->assertEquals(0.0, $t['avg_time']);
        $this->assertEquals(0, $t['stop_memory']);
        $this->assertEquals(0, $t['avg_memory']);
        $this->assertEquals(0, $t['peak_memory']);
    }

    //--------------------------------------------------------------------

    public function testTimerStops()
    {
        $timer = new \Myth\Timer\Timer();

        $timer->start('test');
        $timer->stop('test');

        $t = $timer->get('test');

        $this->assertFalse($t['running']);
    }

    //--------------------------------------------------------------------

    public function testCalcsAccurateTime()
    {
        $timer = new \Myth\Timer\Timer();

        $timer->start('test');
        sleep(1);
        $timer->stop('test');

        $t = $timer->get('test');

        $this->assertEquals(1.0, number_format($t['avg_time'], 1) );
    }

    //--------------------------------------------------------------------

    public function testStoresMemoryValues()
    {
        $timer = new \Myth\Timer\Timer();

        $timer->start('test');
        $i = 0;
        $new = [];
        while ($i < 2000)
        {
            $new[] = [];
            $i++;
        }
        $timer->stop('test');

        $t = $timer->get('test');

        $this->assertTrue($t['avg_memory'] > 0);
        $this->assertTrue(is_numeric($t['peak_memory']));
    }

    //--------------------------------------------------------------------

    public function testOutputCreatesValidString()
    {
        $timer = new \Myth\Timer\Timer();

        $timer->start('test');
        $i = 0;
        $new = [];
        while ($i < 2000)
        {
            $new[] = [];
            $i++;
        }
        $timer->stop('test');

        $t = $timer->get('test');

        $expected = sprintf('[%s] %s seconds, %s memory (%s peak)',
            'test',
            number_format($t['avg_time'], 4),
            $t['avg_memory'],
            $t['peak_memory']
        );

        $this->assertEquals($expected, $timer->output('test'));
    }

    //--------------------------------------------------------------------


}
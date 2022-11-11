<?php

namespace Test\Unit;

use Test\TestCase;
use Kdm\Formatters\StringFormatter;

class StringFormatterTest extends TestCase
{
    /**
     * formatter
     * 
     * @var \Kdm\Formatters\StringFormatter
     */
    protected $formatter;

    /**
     * setUp
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->formatter = new StringFormatter;
    }

    /**
     * testFormat
     * 
     * @return void
     */
    public function testFormat()
    {
        $formatter = $this->formatter;

        $str = $formatter->format(123456);
        $this->assertEquals($str, '123456');
    }
}

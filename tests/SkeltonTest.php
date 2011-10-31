<?php

namespace PHP\Skelton;

/**
 * Test class for PHP.Skelton.
 */
class SkeltonTest extends \PHPUnit_Framework_TestCase
{
    protected $skelton;

    protected function setUp()
    {
        parent::setUp();
        $this->skelton = new Skelton;
    }

    public function test_New()
    {
        $actual = $this->skelton;
        $this->assertInstanceOf('\PHP\Skelton\Skelton', $this->skelton);
    }

    /**
     * @expectedException PHP\Skelton\Exception
     */
    public function test_Exception()
    {
        throw new Exception;
    }
}
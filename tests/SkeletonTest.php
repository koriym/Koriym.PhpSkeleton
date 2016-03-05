<?php

namespace __Vendor__\__Package__;

class __Package__Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @var __Package__
     */
    protected $skeleton;

    protected function setUp()
    {
        parent::setUp();
        $this->skeleton = new __Package__;
    }

    public function testNew()
    {
        $actual = $this->skeleton;
        $this->assertInstanceOf('\__Vendor__\__Package__\__Package__', $actual);
    }
}

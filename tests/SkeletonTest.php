<?php
namespace __Vendor__\__Package__;

use PHPUnit\Framework\TestCase;

class __Package__Test extends TestCase
{
    /**
     * @var __Package__
     */
    protected $skeleton;

    protected function setUp()
    {
        $this->skeleton = new __Package__;
    }

    public function testNew()
    {
        $actual = $this->skeleton;
        $this->assertInstanceOf('\__Vendor__\__Package__\__Package__', $actual);
    }
}

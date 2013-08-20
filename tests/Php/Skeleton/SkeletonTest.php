<?php

namespace Php\Skeleton;

class SkeletonTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Skeleton
     */
    protected $skeleton;

    protected function setUp()
    {
        $this->skeleton = new Skeleton;
    }

    public function testNew()
    {
        $actual = $this->skeleton;
        $this->assertInstanceOf('\Php\Skeleton\Skeleton', $actual);
    }

    /**
     * @expectedException \Php\Skeleton\Exception\LogicException
     */
    public function test_Exception()
    {
        throw new Exception\LogicException;
    }
}

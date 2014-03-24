<?php

namespace PHP\Skeleton;

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
        $this->assertInstanceOf('\PHP\Skeleton\Skeleton', $actual);
    }

    /**
     * @expectedException \PHP\Skeleton\Exception\LogicException
     */
    public function testException()
    {
        throw new Exception\LogicException;
    }
}

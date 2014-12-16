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
        parent::setUp();
        $this->skeleton = new Skeleton;
    }

    public function testNew()
    {
        $actual = $this->skeleton;
        $this->assertInstanceOf('\Php\Skeleton\Skeleton', $actual);
    }

    public function testException()
    {
        $this->setExpectedException('\Php\Skeleton\Exception\LogicException');
        throw new Exception\LogicException;
    }
}

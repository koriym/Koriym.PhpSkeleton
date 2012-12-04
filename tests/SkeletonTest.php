<?php

namespace PHP\Skeleton;

/**
 * Test class for PHP.Skeleton.
 */
class SkeletonTest extends \PHPUnit_Framework_TestCase
{
    protected $Skeleton;

    protected function setUp()
    {
        parent::setUp();
        $this->Skeleton = new Skeleton;
    }

    public function test_New()
    {
        $actual = $this->Skeleton;
        $this->assertInstanceOf('\PHP\Skeleton\Skeleton', $this->Skeleton);
    }

    /**
     * @expectedException PHP\Skeleton\Exception
     */
    public function test_Exception()
    {
        throw new Exception;
    }
}
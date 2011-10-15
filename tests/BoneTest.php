<?php

namespace PHP\Bone;

/**
 * Test class for PHP.Bone.
 */
class BoneTest extends \PHPUnit_Framework_TestCase
{
    protected $bone;

    protected function setUp()
    {
        parent::setUp();
        $this->bone = new Bone;
    }

    public function test_New()
    {
        $actual = $this->bone;
        $this->assertInstanceOf('\PHP\Bone\Bone', $this->bone);
    }

    /**
     * @expectedException PHP\Bone\Exception
     */
    public function test_Exception()
    {
        throw new Exception;
    }
}
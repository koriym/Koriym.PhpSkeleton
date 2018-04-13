<?php
/**
 * This file is part of the __Vendor__.__Package__
 *
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace __Vendor__\__Package__;

use PHPUnit\Framework\TestCase;

class __Package__Test extends TestCase
{
    /**
     * @var __Package__
     */
    protected $__PackageVarName__;

    protected function setUp()
    {
        $this->__PackageVarName__ = new __Package__;
    }

    public function testIsInstanceOf__Package__()
    {
        $actual = $this->__PackageVarName__;
        $this->assertInstanceOf(__Package__::class, $actual);
    }
}

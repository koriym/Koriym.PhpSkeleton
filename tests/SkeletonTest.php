<?php

declare(strict_types=1);

namespace __Vendor__\__Package__;

use PHPUnit\Framework\TestCase;

class __Package__Test extends TestCase
{
    /** @var __Package__ */
    protected $__PackageVarName__;

    protected function setUp(): void
    {
        $this->__PackageVarName__ = new __Package__();
    }

    public function testIsInstanceOf__Package__(): void
    {
        $actual = $this->__PackageVarName__;
        $this->assertInstanceOf(__Package__::class, $actual);
    }
}

<?php

namespace Tests\Unit;

use App\Http\Controllers\MonitorController;
use PHPUnit\Framework\TestCase;

class GenerateRatioTest extends TestCase
{
    protected $monitor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->monitor = new MonitorController();
    }

    public function generateRatio($a, $b)
    {
        return $this->monitor->generateRatio($a, $b);
    }

    public function testGenerateRatioWithPositiveIntegers()
    {
        $this->assertEquals([1, 3], $this->generateRatio(20, 60));
        $this->assertEquals([2, 3], $this->generateRatio(40, 60));
        $this->assertEquals([9, 4], $this->generateRatio(54, 24));
        $this->assertEquals([17, 23], $this->generateRatio(17, 23));
        $this->assertEquals([4, 15], $this->generateRatio(48, 180));
    }

    public function testGenerateRatioWithZero()
    {
        $this->assertEquals([0, 1], $this->generateRatio(0, 5));
        $this->assertEquals([1, 0], $this->generateRatio(7, 0));
        $this->assertEquals([0, 0], $this->generateRatio(0, 0));
    }

    public function testGenerateRatioWithNegativeIntegers()
    {
        $this->assertEquals([9, -4], $this->generateRatio(-54, 24));
        $this->assertEquals([5, 3], $this->generateRatio(-25, -15));
    }
}

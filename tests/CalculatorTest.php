<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Exercises\Calculator;

class CalculatorTest extends TestCase
{
    private Calculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new Calculator();
    }

    public function testAddition(): void
    {
        $result = $this->calculator->add(2, 3);
        $this->assertEquals(5, $result, 'La suma de 2 + 3 debe ser 5');
    }

    public function testSubtraction(): void
    {
        $result = $this->calculator->subtract(5, 3);
        $this->assertEquals(2, $result, 'La resta de 5 - 3 debe ser 2');
    }

    public function testMultiplication(): void
    {
        $result = $this->calculator->multiply(4, 3);
        $this->assertEquals(12, $result, 'La multiplicación de 4 * 3 debe ser 12');
    }

    public function testDivision(): void
    {
        $result = $this->calculator->divide(10, 2);
        $this->assertEquals(5, $result, 'La división de 10 / 2 debe ser 5');
    }

    public function testDivisionByZero(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->calculator->divide(10, 0);
    }

    /**
     * @dataProvider calculationProvider
     */
    public function testCalculationsWithDataProvider($a, $b, $expectedSum, $expectedDiff): void
    {
        $this->assertEquals($expectedSum, $this->calculator->add($a, $b));
        $this->assertEquals($expectedDiff, $this->calculator->subtract($a, $b));
    }

    public function calculationProvider(): array
    {
        return [
            [1, 1, 2, 0],
            [10, 5, 15, 5],
            [-5, 5, 0, -10],
            [0.5, 0.5, 1.0, 0.0],
        ];
    }
}

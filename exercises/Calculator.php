<?php

namespace Exercises;

/**
 * Ejercicio: Implementar una calculadora básica
 */
class Calculator
{
    public function add(float $a, float $b): float
    {
        return $a + $b;
    }

    public function subtract(float $a, float $b): float
    {
        return $a - $b;
    }

    public function multiply(float $a, float $b): float
    {
        return $a * $b;
    }

    public function divide(float $a, float $b): float
    {
        if ($b == 0) {
            throw new \InvalidArgumentException('División por cero no permitida');
        }
        return $a / $b;
    }
}
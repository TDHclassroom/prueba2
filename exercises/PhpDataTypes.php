<?php

namespace Exercises;

/**
 * Ejercicio 1: Fundamentos de PHP - Tipos de Datos
 * 
 * Basado en: https://www.php.net/manual/es/language.types.intro.php
 * 
 * Este ejercicio cubre los tipos de datos fundamentales en PHP:
 * - Tipos escalares: bool, int, float, string
 * - Tipos compuestos: array, object, callable, iterable
 * - Tipos especiales: resource, NULL
 */
class PhpDataTypes
{
    /**
     * Retorna el tipo de dato de una variable usando gettype()
     */
    public function getDataType($variable): string
    {
        // TODO: Implementar usando gettype() para retornar el tipo de la variable
        return gettype($variable);
    }

    /**
     * Verifica si una variable es de tipo boolean
     */
    public function isBool($variable): bool
    {
        // TODO: Implementar verificación usando is_bool()
        return is_bool($variable);
    }

    /**
     * Verifica si una variable es de tipo integer
     */
    public function isInteger($variable): bool
    {
        // TODO: Implementar verificación usando is_int()
        return is_int($variable);
    }

    /**
     * Verifica si una variable es de tipo float (número de punto flotante)
     */
    public function isFloat($variable): bool
    {
        // TODO: Implementar verificación usando is_float()
        return is_float($variable);
    }

    /**
     * Verifica si una variable es de tipo string
     */
    public function isString($variable): bool
    {
        // TODO: Implementar verificación usando is_string()
        return is_string($variable);
    }

    /**
     * Verifica si una variable es de tipo array
     */
    public function isArray($variable): bool
    {
        // TODO: Implementar verificación usando is_array()
        return is_array($variable);
    }

    /**
     * Verifica si una variable es de tipo object
     */
    public function isObject($variable): bool
    {
        // TODO: Implementar verificación usando is_object()
        return is_object($variable);
    }

    /**
     * Verifica si una variable es NULL
     */
    public function isNull($variable): bool
    {
        // TODO: Implementar verificación usando is_null()
        return is_null($variable);
    }

    /**
     * Convierte un valor a boolean según las reglas de PHP
     * 
     * Valores que se consideran FALSE:
     * - boolean FALSE
     * - integer 0
     * - float 0.0
     * - string vacío "" y "0"
     * - array vacío
     * - NULL
     */
    public function convertToBool($variable): bool
    {
        // TODO: Implementar conversión a boolean usando (bool)
        return (bool) $variable;
    }

    /**
     * Convierte un valor a integer
     */
    public function convertToInt($variable): int
    {
        // TODO: Implementar conversión a integer usando (int)
        return (int) $variable;
    }

    /**
     * Convierte un valor a float
     */
    public function convertToFloat($variable): float
    {
        // TODO: Implementar conversión a float usando (float)
        return (float) $variable;
    }

    /**
     * Convierte un valor a string
     */
    public function convertToString($variable): string
    {
        // TODO: Implementar conversión a string usando (string)
        return (string) $variable;
    }

    /**
     * Crea un array con diferentes tipos de datos
     * Debe retornar un array que contenga:
     * - Un boolean true
     * - Un integer 42
     * - Un float 3.14
     * - Un string "PHP"
     * - Un array vacío
     * - NULL
     */
    public function createMixedArray(): array
    {
        // TODO: Implementar creación del array mixto
        return [
            true,
            42,
            3.14,
            "PHP",
            [],
            null
        ];
    }

    /**
     * Verifica si una variable está definida y no es NULL
     */
    public function isSet($variable): bool
    {
        // TODO: Implementar usando isset()
        return isset($variable);
    }

    /**
     * Verifica si una variable está vacía
     * 
     * Se considera vacía si:
     * - "" (string vacío)
     * - 0 (integer)
     * - 0.0 (float)
     * - "0" (string)
     * - NULL
     * - FALSE
     * - array() (array vacío)
     */
    public function isEmpty($variable): bool
    {
        // TODO: Implementar usando empty()
        return empty($variable);
    }

    /**
     * Retorna información detallada sobre una variable
     * usando var_dump capturado como string
     */
    public function getVarDump($variable): string
    {
        // TODO: Implementar captura de var_dump usando ob_start() y ob_get_clean()
        ob_start();
        var_dump($variable);
        return ob_get_clean();
    }

    /**
     * Compara dos variables usando comparación estricta
     */
    public function strictEquals($a, $b): bool
    {
        // TODO: Implementar comparación estricta usando ===
        return $a === $b;
    }

    /**
     * Compara dos variables usando comparación suave
     */
    public function looseEquals($a, $b): bool
    {
        // TODO: Implementar comparación suave usando ==
        return $a == $b;
    }
}

<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Exercises\PhpDataTypes;
use stdClass;

class PhpDataTypesTest extends TestCase
{
    private PhpDataTypes $phpDataTypes;

    protected function setUp(): void
    {
        $this->phpDataTypes = new PhpDataTypes();
    }

    /**
     * Test gettype() functionality
     */
    public function testGetDataType(): void
    {
        $this->assertEquals('boolean', $this->phpDataTypes->getDataType(true));
        $this->assertEquals('integer', $this->phpDataTypes->getDataType(42));
        $this->assertEquals('double', $this->phpDataTypes->getDataType(3.14)); // float returns 'double'
        $this->assertEquals('string', $this->phpDataTypes->getDataType('PHP'));
        $this->assertEquals('array', $this->phpDataTypes->getDataType([]));
        $this->assertEquals('object', $this->phpDataTypes->getDataType(new stdClass()));
        $this->assertEquals('NULL', $this->phpDataTypes->getDataType(null));
    }

    /**
     * Test boolean type checking
     */
    public function testIsBool(): void
    {
        $this->assertTrue($this->phpDataTypes->isBool(true));
        $this->assertTrue($this->phpDataTypes->isBool(false));
        $this->assertFalse($this->phpDataTypes->isBool(1));
        $this->assertFalse($this->phpDataTypes->isBool(0));
        $this->assertFalse($this->phpDataTypes->isBool('true'));
        $this->assertFalse($this->phpDataTypes->isBool(null));
    }

    /**
     * Test integer type checking
     */
    public function testIsInteger(): void
    {
        $this->assertTrue($this->phpDataTypes->isInteger(42));
        $this->assertTrue($this->phpDataTypes->isInteger(0));
        $this->assertTrue($this->phpDataTypes->isInteger(-10));
        $this->assertFalse($this->phpDataTypes->isInteger(3.14));
        $this->assertFalse($this->phpDataTypes->isInteger('42'));
        $this->assertFalse($this->phpDataTypes->isInteger(true));
    }

    /**
     * Test float type checking
     */
    public function testIsFloat(): void
    {
        $this->assertTrue($this->phpDataTypes->isFloat(3.14));
        $this->assertTrue($this->phpDataTypes->isFloat(0.0));
        $this->assertTrue($this->phpDataTypes->isFloat(-2.5));
        $this->assertFalse($this->phpDataTypes->isFloat(42));
        $this->assertFalse($this->phpDataTypes->isFloat('3.14'));
        $this->assertFalse($this->phpDataTypes->isFloat(true));
    }

    /**
     * Test string type checking
     */
    public function testIsString(): void
    {
        $this->assertTrue($this->phpDataTypes->isString('PHP'));
        $this->assertTrue($this->phpDataTypes->isString(''));
        $this->assertTrue($this->phpDataTypes->isString('0'));
        $this->assertFalse($this->phpDataTypes->isString(42));
        $this->assertFalse($this->phpDataTypes->isString(true));
        $this->assertFalse($this->phpDataTypes->isString(null));
    }

    /**
     * Test array type checking
     */
    public function testIsArray(): void
    {
        $this->assertTrue($this->phpDataTypes->isArray([]));
        $this->assertTrue($this->phpDataTypes->isArray([1, 2, 3]));
        $this->assertTrue($this->phpDataTypes->isArray(['key' => 'value']));
        $this->assertFalse($this->phpDataTypes->isArray('array'));
        $this->assertFalse($this->phpDataTypes->isArray(42));
        $this->assertFalse($this->phpDataTypes->isArray(null));
    }

    /**
     * Test object type checking
     */
    public function testIsObject(): void
    {
        $this->assertTrue($this->phpDataTypes->isObject(new stdClass()));
        $this->assertTrue($this->phpDataTypes->isObject($this));
        $this->assertFalse($this->phpDataTypes->isObject('object'));
        $this->assertFalse($this->phpDataTypes->isObject([]));
        $this->assertFalse($this->phpDataTypes->isObject(null));
    }

    /**
     * Test NULL type checking
     */
    public function testIsNull(): void
    {
        $this->assertTrue($this->phpDataTypes->isNull(null));
        $this->assertFalse($this->phpDataTypes->isNull(false));
        $this->assertFalse($this->phpDataTypes->isNull(0));
        $this->assertFalse($this->phpDataTypes->isNull(''));
        $this->assertFalse($this->phpDataTypes->isNull([]));
    }

    /**
     * Test boolean conversion
     */
    public function testConvertToBool(): void
    {
        // Values that convert to TRUE
        $this->assertTrue($this->phpDataTypes->convertToBool(true));
        $this->assertTrue($this->phpDataTypes->convertToBool(1));
        $this->assertTrue($this->phpDataTypes->convertToBool(-1));
        $this->assertTrue($this->phpDataTypes->convertToBool(3.14));
        $this->assertTrue($this->phpDataTypes->convertToBool('PHP'));
        $this->assertTrue($this->phpDataTypes->convertToBool([1, 2, 3]));

        // Values that convert to FALSE
        $this->assertFalse($this->phpDataTypes->convertToBool(false));
        $this->assertFalse($this->phpDataTypes->convertToBool(0));
        $this->assertFalse($this->phpDataTypes->convertToBool(0.0));
        $this->assertFalse($this->phpDataTypes->convertToBool(''));
        $this->assertFalse($this->phpDataTypes->convertToBool('0'));
        $this->assertFalse($this->phpDataTypes->convertToBool([]));
        $this->assertFalse($this->phpDataTypes->convertToBool(null));
    }

    /**
     * Test integer conversion
     */
    public function testConvertToInt(): void
    {
        $this->assertEquals(1, $this->phpDataTypes->convertToInt(true));
        $this->assertEquals(0, $this->phpDataTypes->convertToInt(false));
        $this->assertEquals(42, $this->phpDataTypes->convertToInt(42.7));
        $this->assertEquals(123, $this->phpDataTypes->convertToInt('123'));
        $this->assertEquals(123, $this->phpDataTypes->convertToInt('123abc'));
        $this->assertEquals(0, $this->phpDataTypes->convertToInt('abc'));
        $this->assertEquals(0, $this->phpDataTypes->convertToInt(null));
    }

    /**
     * Test float conversion
     */
    public function testConvertToFloat(): void
    {
        $this->assertEquals(1.0, $this->phpDataTypes->convertToFloat(true));
        $this->assertEquals(0.0, $this->phpDataTypes->convertToFloat(false));
        $this->assertEquals(42.0, $this->phpDataTypes->convertToFloat(42));
        $this->assertEquals(123.45, $this->phpDataTypes->convertToFloat('123.45'));
        $this->assertEquals(123.45, $this->phpDataTypes->convertToFloat('123.45abc'));
        $this->assertEquals(0.0, $this->phpDataTypes->convertToFloat('abc'));
        $this->assertEquals(0.0, $this->phpDataTypes->convertToFloat(null));
    }

    /**
     * Test string conversion
     */
    public function testConvertToString(): void
    {
        $this->assertEquals('1', $this->phpDataTypes->convertToString(true));
        $this->assertEquals('', $this->phpDataTypes->convertToString(false));
        $this->assertEquals('42', $this->phpDataTypes->convertToString(42));
        $this->assertEquals('3.14', $this->phpDataTypes->convertToString(3.14));
        $this->assertEquals('PHP', $this->phpDataTypes->convertToString('PHP'));
        $this->assertEquals('', $this->phpDataTypes->convertToString(null));
    }

    /**
     * Test creating mixed array
     */
    public function testCreateMixedArray(): void
    {
        $expected = [
            true,
            42,
            3.14,
            "PHP",
            [],
            null
        ];
        
        $result = $this->phpDataTypes->createMixedArray();
        
        $this->assertEquals($expected, $result);
        $this->assertCount(6, $result);
        $this->assertTrue($this->phpDataTypes->isBool($result[0]));
        $this->assertTrue($this->phpDataTypes->isInteger($result[1]));
        $this->assertTrue($this->phpDataTypes->isFloat($result[2]));
        $this->assertTrue($this->phpDataTypes->isString($result[3]));
        $this->assertTrue($this->phpDataTypes->isArray($result[4]));
        $this->assertTrue($this->phpDataTypes->isNull($result[5]));
    }

    /**
     * Test isset functionality
     */
    public function testIsSet(): void
    {
        $defined = 'test';
        $undefined = null;
        
        $this->assertTrue($this->phpDataTypes->isSet($defined));
        $this->assertTrue($this->phpDataTypes->isSet(''));
        $this->assertTrue($this->phpDataTypes->isSet(0));
        $this->assertTrue($this->phpDataTypes->isSet(false));
        $this->assertFalse($this->phpDataTypes->isSet($undefined));
    }

    /**
     * Test empty functionality
     */
    public function testIsEmpty(): void
    {
        // Empty values
        $this->assertTrue($this->phpDataTypes->isEmpty(''));
        $this->assertTrue($this->phpDataTypes->isEmpty(0));
        $this->assertTrue($this->phpDataTypes->isEmpty(0.0));
        $this->assertTrue($this->phpDataTypes->isEmpty('0'));
        $this->assertTrue($this->phpDataTypes->isEmpty(null));
        $this->assertTrue($this->phpDataTypes->isEmpty(false));
        $this->assertTrue($this->phpDataTypes->isEmpty([]));

        // Non-empty values
        $this->assertFalse($this->phpDataTypes->isEmpty('PHP'));
        $this->assertFalse($this->phpDataTypes->isEmpty(1));
        $this->assertFalse($this->phpDataTypes->isEmpty(true));
        $this->assertFalse($this->phpDataTypes->isEmpty([1, 2, 3]));
    }

    /**
     * Test var_dump capture
     */
    public function testGetVarDump(): void
    {
        $result = $this->phpDataTypes->getVarDump(42);
        $this->assertStringContainsString('int(42)', $result);

        $result = $this->phpDataTypes->getVarDump('PHP');
        $this->assertStringContainsString('string(3) "PHP"', $result);

        $result = $this->phpDataTypes->getVarDump(true);
        $this->assertStringContainsString('bool(true)', $result);
    }

    /**
     * Test strict comparison
     */
    public function testStrictEquals(): void
    {
        $this->assertTrue($this->phpDataTypes->strictEquals(42, 42));
        $this->assertTrue($this->phpDataTypes->strictEquals('PHP', 'PHP'));
        $this->assertTrue($this->phpDataTypes->strictEquals(true, true));
        
        // These should be false with strict comparison
        $this->assertFalse($this->phpDataTypes->strictEquals(42, '42'));
        $this->assertFalse($this->phpDataTypes->strictEquals(true, 1));
        $this->assertFalse($this->phpDataTypes->strictEquals(false, 0));
        $this->assertFalse($this->phpDataTypes->strictEquals(null, ''));
    }

    /**
     * Test loose comparison
     */
    public function testLooseEquals(): void
    {
        $this->assertTrue($this->phpDataTypes->looseEquals(42, 42));
        $this->assertTrue($this->phpDataTypes->looseEquals('PHP', 'PHP'));
        
        // These should be true with loose comparison
        $this->assertTrue($this->phpDataTypes->looseEquals(42, '42'));
        $this->assertTrue($this->phpDataTypes->looseEquals(true, 1));
        $this->assertTrue($this->phpDataTypes->looseEquals(false, 0));
        $this->assertTrue($this->phpDataTypes->looseEquals(null, ''));
        
        // These should still be false
        $this->assertFalse($this->phpDataTypes->looseEquals(42, 43));
        $this->assertFalse($this->phpDataTypes->looseEquals('PHP', 'JAVA'));
    }

    /**
     * Data provider for testing various type combinations
     * 
     * @dataProvider typeExamplesProvider
     */
    public function testVariousTypes($value, $expectedType, $expectedBoolConversion): void
    {
        $this->assertEquals($expectedType, $this->phpDataTypes->getDataType($value));
        $this->assertEquals($expectedBoolConversion, $this->phpDataTypes->convertToBool($value));
    }

    public function typeExamplesProvider(): array
    {
        return [
            // [value, expected_type, expected_bool_conversion]
            [true, 'boolean', true],
            [false, 'boolean', false],
            [42, 'integer', true],
            [0, 'integer', false],
            [-1, 'integer', true],
            [3.14, 'double', true], // gettype() returns 'double' for floats
            [0.0, 'double', false],
            ['PHP', 'string', true],
            ['', 'string', false],
            ['0', 'string', false],
            [[], 'array', false],
            [[1, 2, 3], 'array', true],
            [null, 'NULL', false],
        ];
    }
}

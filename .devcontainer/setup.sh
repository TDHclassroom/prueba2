#!/bin/bash

# Configuración inicial del entorno PHP para ejercicios y testing

echo "🚀 Configurando entorno PHP para ejercicios y testing..."

# Actualizar el sistema
sudo apt-get update

# Instalar dependencias adicionales
sudo apt-get install -y \
    zip \
    unzip \
    git \
    curl \
    wget \
    vim \
    nano \
    htop \
    tree \
    sqlite3 \
    jq \
    bc

echo "🔧 Dependencias adicionales instaladas: jq, bc"

# Instalar Composer globalmente
echo "📦 Instalando Composer..."
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php --install-dir=/usr/local/bin --filename=composer
php -r "unlink('composer-setup.php');"

# Verificar instalación de Composer
composer --version

# Instalar PHPUnit globalmente
echo "🧪 Configurando PHPUnit..."
composer global require phpunit/phpunit

# Detectar el directorio del proyecto dinámicamente
PROJECT_ROOT="${GITHUB_WORKSPACE:-$PROJECT_ROOT}"

# Si estamos en un entorno diferente, usar el directorio actual
if [ ! -d "$PROJECT_ROOT" ]; then
    PROJECT_ROOT="$(pwd)"
fi

echo "📁 Usando directorio del proyecto: $PROJECT_ROOT"

# Crear estructura de directorios para ejercicios
echo "📁 Creando estructura de directorios..."
mkdir -p "$PROJECT_ROOT/exercises"
mkdir -p "$PROJECT_ROOT/tests"
mkdir -p "$PROJECT_ROOT/solutions"
mkdir -p "$PROJECT_ROOT/public"

# Crear configuración de PHPUnit
cat > "$PROJECT_ROOT/phpunit.xml" << 'EOF'
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="https://schema.phpunit.de/10.5/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true"
         testdox="true">
    
    <testsuites>
        <testsuite name="Exercises">
            <directory>tests</directory>
        </testsuite>
    </testsuites>
    
    <source>
        <include>
            <directory>exercises</directory>
        </include>
    </source>
    
    <logging>
        <testdoxHtml outputFile="test-results.html"/>
        <junit outputFile="junit-results.xml"/>
    </logging>
</phpunit>
EOF

# Crear composer.json para el proyecto
cat > $PROJECT_ROOT/composer.json << 'EOF'
{
    "name": "php-exercises/testing-environment",
    "description": "Entorno de desarrollo para ejercicios PHP con tests automáticos",
    "type": "project",
    "require": {
        "php": "^8.2"
    },
    "require-dev": {
        "phpunit/phpunit": "^10.5",
        "phpstan/phpstan": "^1.10",
        "squizlabs/php_codesniffer": "^3.7"
    },
    "autoload": {
        "psr-4": {
            "Exercises\\": "exercises/",
            "Solutions\\": "solutions/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Tests\\": "tests/"
        }
    },
    "scripts": {
        "test": "phpunit",
        "test-watch": "phpunit --testdox",
        "analyze": "phpstan analyse exercises solutions --level=8",
        "style-check": "phpcs exercises solutions --standard=PSR12",
        "style-fix": "phpcbf exercises solutions --standard=PSR12",
        "serve": "php -S localhost:8000 -t public"
    }
}
EOF

# Instalar dependencias del proyecto
echo "📚 Instalando dependencias del proyecto..."
cd $PROJECT_ROOT
composer install

# Crear archivo de ejemplo de ejercicio
cat > $PROJECT_ROOT/exercises/Calculator.php << 'EOF'
<?php

namespace Exercises;

/**
 * Ejercicio: Implementar una calculadora básica
 */
class Calculator
{
    /**
     * Suma dos números
     * 
     * @param float $a
     * @param float $b
     * @return float
     */
    public function add(float $a, float $b): float
    {
        // TODO: Implementar la suma
        return 0;
    }

    /**
     * Resta dos números
     * 
     * @param float $a
     * @param float $b
     * @return float
     */
    public function subtract(float $a, float $b): float
    {
        // TODO: Implementar la resta
        return 0;
    }

    /**
     * Multiplica dos números
     * 
     * @param float $a
     * @param float $b
     * @return float
     */
    public function multiply(float $a, float $b): float
    {
        // TODO: Implementar la multiplicación
        return 0;
    }

    /**
     * Divide dos números
     * 
     * @param float $a
     * @param float $b
     * @return float
     * @throws \InvalidArgumentException cuando se divide por cero
     */
    public function divide(float $a, float $b): float
    {
        // TODO: Implementar la división
        // Recordar validar división por cero
        return 0;
    }
}
EOF

# Crear test de ejemplo
cat > $PROJECT_ROOT/tests/CalculatorTest.php << 'EOF'
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
EOF

# Crear solución de ejemplo
cat > $PROJECT_ROOT/solutions/Calculator.php << 'EOF'
<?php

namespace Solutions;

/**
 * Solución: Calculadora básica implementada
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
EOF

# Crear página web para mostrar resultados
cat > $PROJECT_ROOT/public/index.php << 'EOF'
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Exercises - Testing Environment</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f4; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #333; }
        .status { padding: 10px; margin: 10px 0; border-radius: 4px; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .info { background: #cce7ff; color: #004085; border: 1px solid #bee5eb; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 4px; overflow-x: auto; }
        .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; margin: 5px; }
        .btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 PHP Exercises - Testing Environment</h1>
        
        <div class="info">
            <strong>Bienvenido al entorno de ejercicios PHP</strong><br>
            Este entorno está configurado para desarrollo y testing automático de ejercicios PHP.
        </div>

        <h2>Estado del Sistema</h2>
        <div class="success">
            ✅ PHP Version: <?php echo PHP_VERSION; ?>
        </div>
        <div class="success">
            ✅ Composer: Instalado
        </div>
        <div class="success">
            ✅ PHPUnit: Configurado
        </div>

        <h2>Acciones Rápidas</h2>
        <a href="test-results.php" class="btn">Ver Resultados de Tests</a>
        <a href="phpinfo.php" class="btn">PHP Info</a>

        <h2>Estructura del Proyecto</h2>
        <pre>
$PROJECT_ROOT/
├── exercises/          # Ejercicios para completar
├── solutions/          # Soluciones de referencia
├── tests/             # Tests automáticos
├── public/            # Archivos web públicos
├── phpunit.xml        # Configuración de PHPUnit
└── composer.json      # Dependencias del proyecto
        </pre>

        <h2>Comandos Útiles</h2>
        <pre>
# Ejecutar todos los tests
composer test

# Ejecutar tests con detalles
composer test-watch

# Análisis estático del código
composer analyze

# Verificar estilo de código
composer style-check

# Corregir estilo automáticamente
composer style-fix

# Iniciar servidor de desarrollo
composer serve
        </pre>

        <h2>Información de Desarrollo</h2>
        <div class="info">
            <strong>Puerto 8000:</strong> Servidor PHP de desarrollo<br>
            <strong>Puerto 5500:</strong> Live Server (recarga automática)<br>
            <strong>Puerto 3000:</strong> Servidor Node.js (si es necesario)
        </div>
    </div>
</body>
</html>
EOF

# Crear página para mostrar resultados de tests
cat > $PROJECT_ROOT/public/test-results.php << 'EOF'
<?php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Tests</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f4; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; margin: 5px; }
        .btn:hover { background: #0056b3; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 4px; overflow-x: auto; white-space: pre-wrap; }
        .refresh-info { background: #cce7ff; padding: 10px; border-radius: 4px; margin: 20px 0; }
    </style>
    <script>
        function runTests() {
            document.getElementById('results').innerHTML = '<p>Ejecutando tests...</p>';
            fetch('run-tests.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('results').innerHTML = data;
                });
        }
        
        // Auto-refresh cada 30 segundos
        setInterval(runTests, 30000);
    </script>
</head>
<body>
    <div class="container">
        <h1>📊 Resultados de Tests</h1>
        
        <div class="refresh-info">
            <strong>Auto-refresh:</strong> Esta página se actualiza automáticamente cada 30 segundos.<br>
            También puedes hacer clic en "Ejecutar Tests" para una actualización manual.
        </div>
        
        <button onclick="runTests()" class="btn">🧪 Ejecutar Tests</button>
        <a href="index.php" class="btn">← Volver al Inicio</a>
        
        <h2>Resultados</h2>
        <div id="results">
            <p>Haz clic en "Ejecutar Tests" para ver los resultados.</p>
        </div>
    </div>
</body>
</html>
EOF

# Crear endpoint para ejecutar tests
cat > "$PROJECT_ROOT/public/run-tests.php" << EOF
<?php
// Cambiar al directorio del proyecto (dinámico)
\$projectRoot = dirname(__DIR__);
chdir(\$projectRoot);

// Ejecutar PHPUnit y capturar la salida
ob_start();
\$output = shell_exec('vendor/bin/phpunit --testdox --colors=never 2>&1');
ob_end_clean();

// Leer también el archivo HTML de resultados si existe
\$htmlResults = '';
\$htmlResultsPath = \$projectRoot . '/test-results.html';
if (file_exists(\$htmlResultsPath)) {
    \$htmlResults = file_get_contents(\$htmlResultsPath);
}

echo "<pre>" . htmlspecialchars(\$output) . "</pre>";

if (\$htmlResults) {
    echo "<h3>Resultados Detallados</h3>";
    echo \$htmlResults;
}
?>
EOF

# Crear página de información de PHP
cat > $PROJECT_ROOT/public/phpinfo.php << 'EOF'
<?php
phpinfo();
?>
EOF

# Crear archivo README con instrucciones
cat > $PROJECT_ROOT/README.md << 'EOF'
# 🧪 PHP Exercises - Testing Environment

Este es un entorno de desarrollo completo para ejercicios PHP con tests automáticos, configurado con GitHub Codespaces y devcontainer.

## 🚀 Características

- **PHP 8.2** con extensiones completas
- **PHPUnit** para testing automático  
- **Composer** para gestión de dependencias
- **Análisis estático** con PHPStan
- **Code Sniffer** para estándares de código
- **Hot-reload** con servidor de desarrollo
- **Extensiones de VS Code** preconfiguradas
- **Interfaz web** para ver resultados

## 📁 Estructura del Proyecto

```
$PROJECT_ROOT/
├── .devcontainer/          # Configuración del devcontainer
├── exercises/              # 📝 Ejercicios para completar
├── solutions/              # ✅ Soluciones de referencia
├── tests/                  # 🧪 Tests automáticos
├── public/                 # 🌐 Archivos web públicos
├── vendor/                 # 📦 Dependencias de Composer
├── phpunit.xml            # ⚙️ Configuración de PHPUnit
├── composer.json          # 📋 Dependencias del proyecto
└── README.md              # 📚 Este archivo
```

## 🏃‍♂️ Inicio Rápido

### 1. Desarrollo de Ejercicios

Los ejercicios están en la carpeta `exercises/`. Ejemplo:

```php
// exercises/Calculator.php
<?php
namespace Exercises;

class Calculator {
    public function add(float $a, float $b): float {
        // TODO: Implementar la suma
        return 0;
    }
}
```

### 2. Tests Automáticos

Los tests están en la carpeta `tests/`:

```php
// tests/CalculatorTest.php
<?php
namespace Tests;

use PHPUnit\Framework\TestCase;
use Exercises\Calculator;

class CalculatorTest extends TestCase {
    public function testAddition(): void {
        $calc = new Calculator();
        $this->assertEquals(5, $calc->add(2, 3));
    }
}
```

### 3. Comandos Útiles

```bash
# Ejecutar todos los tests
composer test

# Ejecutar tests con detalles
composer test-watch

# Análisis estático del código
composer analyze

# Verificar estilo de código PSR-12
composer style-check

# Corregir estilo automáticamente
composer style-fix

# Iniciar servidor de desarrollo en puerto 8000
composer serve
```

## 🌐 Interfaz Web

Una vez iniciado el codespace, puedes acceder a:

- **http://localhost:8000** - Página principal del proyecto
- **http://localhost:8000/test-results.php** - Resultados de tests en tiempo real
- **http://localhost:8000/phpinfo.php** - Información de PHP

## 🔧 Extensiones Incluidas

### PHP Development
- **Intelephense** - IntelliSense avanzado para PHP
- **PHP Debug** - Debugging con Xdebug
- **PHPTools** - Herramientas completas de PHP
- **PHP Sniffer** - Verificación de estándares de código
- **PHPUnit** - Integración con tests

### Development Tools
- **Live Server** - Hot-reload para desarrollo web
- **Prettier** - Formateo de código
- **Test Explorer** - Vista de tests en el sidebar

### GitHub Integration
- **GitHub Pull Requests** - Gestión de PRs
- **GitHub Copilot** - Asistente de código IA

## 📊 Testing Workflow

### Para Estudiantes:
1. Abrir el ejercicio en `exercises/`
2. Implementar la solución
3. Ejecutar `composer test` para verificar
4. Ver resultados en la interfaz web

### Para Profesores:
1. Crear nuevos ejercicios en `exercises/`
2. Crear tests correspondientes en `tests/`
3. Colocar soluciones en `solutions/` como referencia
4. Los estudiantes heredarán automáticamente el entorno

## 🎯 Flujo de Corrección Automática

1. **Desarrollo**: Estudiante implementa en `exercises/`
2. **Testing**: Sistema ejecuta tests automáticamente
3. **Feedback**: Resultados visibles en tiempo real
4. **Evaluación**: Profesor puede comparar con `solutions/`

## ⚙️ Configuración Avanzada

### PHPUnit Configuration
El archivo `phpunit.xml` está configurado para:
- Tests con colores y formato testdox
- Coverage reports
- Exportación de resultados a HTML y XML

### Composer Scripts
- `test`: Ejecuta PHPUnit básico
- `test-watch`: PHPUnit con formato detallado  
- `analyze`: PHPStan level 8
- `style-check`: PHP_CodeSniffer PSR-12
- `style-fix`: PHP_CodeBulkFixer automático
- `serve`: Servidor PHP en puerto 8000

## 🐛 Troubleshooting

### Tests no se ejecutan
```bash
composer install
composer dump-autoload
```

### Servidor no inicia
```bash
php -S localhost:8000 -t public
```

### Problemas de permisos
```bash
sudo chmod -R 755 $PROJECT_ROOT
```

## 📚 Recursos Adicionales

- [Documentación PHPUnit](https://phpunit.de/documentation.html)
- [PSR-12 Coding Standard](https://www.php-fig.org/psr/psr-12/)
- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [Composer Documentation](https://getcomposer.org/doc/)

---

✨ **¡Listo para empezar a programar y probar en PHP!** ✨
EOF

# Configurar permisos
chmod +x $PROJECT_ROOT/.devcontainer/setup.sh
chmod 755 $PROJECT_ROOT/public/*.php

# Mensaje final
echo "✅ Configuración completada!"
echo ""
echo "🎉 Entorno PHP listo para ejercicios y testing automático"
echo ""
echo "📝 Próximos pasos:"
echo "   1. Reiniciar el codespace para aplicar todas las configuraciones"
echo "   2. Abrir http://localhost:8000 para la interfaz web"
echo "   3. Ejecutar 'composer test' para probar el sistema"
echo "   4. Comenzar a desarrollar en la carpeta 'exercises/'"
echo ""
echo "🚀 ¡Happy coding!"

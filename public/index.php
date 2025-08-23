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
        <a href="autograding-report.php" class="btn">Ver Informe de Autograding</a>
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

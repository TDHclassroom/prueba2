<?php
// Ejecutar el script de autograding y mostrar resultados
$reportPath = '../reports/autograding-report.md';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Autograding</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f4f4f4; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .btn { display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; margin: 5px; }
        .btn:hover { background: #0056b3; }
        .btn.success { background: #28a745; }
        .btn.warning { background: #ffc107; color: #212529; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 4px; overflow-x: auto; white-space: pre-wrap; }
        .score-box { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center; }
        .test-result { padding: 10px; margin: 5px 0; border-radius: 4px; }
        .passed { background: #d4edda; color: #155724; border-left: 4px solid #28a745; }
        .failed { background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545; }
        .loading { text-align: center; padding: 20px; }
    </style>
    <script>
        function runAutograding() {
            window.location.hash = '#view-results';
            document.getElementById('results').innerHTML = '<div class="loading"><img src="images/loading.gif" alt="Loading" /><p>🔄 Ejecutando autograding... esto puede tomar unos minutos.</p></div>';
            
            fetch('run-autograding.php')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('results').innerHTML = data;
                })
                .catch(error => {
                    document.getElementById('results').innerHTML = '<div class="failed">❌ Error al ejecutar autograding: ' + error + '</div>';
                });
        }
    </script>
</head>
<body>
    <img src="images/loading.gif" style="display: none;" />
    <div class="container">
        <h1>📊 Reporte de Autograding</h1>
        
        <div style="background: #cce7ff; padding: 15px; border-radius: 4px; margin: 20px 0;">
            <strong>GitHub Classroom Autograding</strong><br>
            Este reporte simula la evaluación automática que se ejecuta en GitHub Classroom.
        </div>
        
        <button onclick="runAutograding()" class="btn success">🧪 Ejecutar Autograding</button>
        <a href="index.php" class="btn">← Volver al Inicio</a>
        <a href="test-results.php" class="btn">Ver Tests Detallados</a>
        
        <div class="score-box">
            <h2>🎯 Sistema de Evaluación</h2>
            <?php
            // Calcular puntuación total dinámica desde autograding.json
            $autogradingFile = '../.github/classroom/autograding.json';
            $totalPoints = 0;
            $functionalPoints = 0;
            $qualityPoints = 0;
            
            if (file_exists($autogradingFile)) {
                $autogradingData = json_decode(file_get_contents($autogradingFile), true);
                
                if ($autogradingData && isset($autogradingData['tests'])) {
                    foreach ($autogradingData['tests'] as $test) {
                        $points = $test['points'] ?? 0;
                        $testName = $test['name'] ?? '';
                        $command = $test['run'] ?? '';
                        
                        $totalPoints += $points;
                        
                        // Categorizar puntos automáticamente
                        if (strpos($command, 'phpcs') !== false || strpos($command, 'phpstan') !== false || 
                            strpos($testName, 'PSR-12') !== false || strpos($testName, 'Estático') !== false ||
                            strpos($testName, 'Documentación') !== false) {
                            $qualityPoints += $points;
                        } else {
                            $functionalPoints += $points;
                        }
                    }
                }
            }
            
            // Fallback si no se puede leer el archivo
            if ($totalPoints == 0) {
                $totalPoints = 25;
                $functionalPoints = 15;
                $qualityPoints = 10;
            }
            ?>
            <p><strong>Puntuación Total:</strong> <?php echo number_format($totalPoints, 2); ?> puntos</p>
            <div style="display: flex; justify-content: space-around; margin-top: 15px;">
                <div>
                    <strong>Tests Funcionales</strong><br>
                    <?php echo number_format($functionalPoints, 2); ?> puntos
                </div>
                <div>
                    <strong>Calidad de Código</strong><br>
                    <?php echo number_format($qualityPoints, 2); ?> puntos
                </div>
            </div>
        </div>

        <h2>Criterios de Evaluación</h2>
        <?php
        // Leer y procesar autograding.json dinámicamente
        $autogradingFile = '../.github/classroom/autograding.json';
        $totalPointsDisplay = 0;
        
        if (file_exists($autogradingFile)) {
            $autogradingData = json_decode(file_get_contents($autogradingFile), true);
            
            if ($autogradingData && isset($autogradingData['tests'])) {
                foreach ($autogradingData['tests'] as $test) {
                    $testName = htmlspecialchars($test['name'] ?? 'Test sin nombre');
                    $points = number_format($test['points'] ?? 0, 2);
                    $totalPointsDisplay += $test['points'] ?? 0;
                    
                    // Generar descripción automática basada en el nombre y comando
                    $description = '';
                    $command = $test['run'] ?? '';
                    
                    if (strpos($testName, 'Suma') !== false) {
                        $description = 'Implementar método add() correctamente';
                    } elseif (strpos($testName, 'Resta') !== false) {
                        $description = 'Implementar método subtract() correctamente';
                    } elseif (strpos($testName, 'Multiplicación') !== false) {
                        $description = 'Implementar método multiply() correctamente';
                    } elseif (strpos($testName, 'División') !== false && strpos($testName, 'Cero') === false) {
                        $description = 'Implementar método divide() correctamente';
                    } elseif (strpos($testName, 'División por Cero') !== false) {
                        $description = 'Manejar excepciones apropiadamente';
                    } elseif (strpos($testName, 'Data Provider') !== false) {
                        $description = 'Funcionar con casos múltiples de datos';
                    } elseif (strpos($testName, 'PSR-12') !== false || strpos($command, 'phpcs') !== false) {
                        $description = 'Cumplir estándares de código PSR-12';
                    } elseif (strpos($testName, 'PHPStan') !== false || strpos($command, 'phpstan') !== false) {
                        $description = 'Código libre de errores detectables por análisis estático';
                    } elseif (strpos($testName, 'Final') !== false || strpos($testName, 'Todos') !== false) {
                        $description = 'Todos los tests pasan correctamente';
                    } elseif (strpos($testName, 'Documentación') !== false || strpos($command, 'README') !== false) {
                        $description = 'Documentación del proyecto completa';
                    } else {
                        $description = 'Test específico según configuración';
                    }
                    
                    echo '<div class="test-result passed">';
                    echo '<strong>' . $testName . ' (' . $points . ' puntos)</strong> - ' . $description;
                    echo '</div>' . "\n        ";
                }
                
                // Mostrar total dinámico
                echo '<div style="margin-top: 15px; padding: 10px; background: #e7f3ff; border-left: 4px solid #0066cc; border-radius: 4px;">';
                echo '<strong>📊 Total: ' . number_format($totalPointsDisplay, 2) . ' puntos disponibles</strong>';
                echo '</div>';
            } else {
                echo '<div class="test-result failed">';
                echo '<strong>Error:</strong> No se pudieron cargar los tests desde autograding.json';
                echo '</div>';
            }
        } else {
            // Fallback a contenido estático si no existe el archivo
            echo '<div class="test-result failed">';
            echo '<strong>⚠️ Archivo autograding.json no encontrado</strong> - Usando configuración por defecto';
            echo '</div>';
            ?>
            <div class="test-result passed">
                <strong>Test Suma (2 puntos)</strong> - Implementar método add() correctamente
            </div>
            <div class="test-result passed">
                <strong>Test Resta (2 puntos)</strong> - Implementar método subtract() correctamente  
            </div>
            <div class="test-result passed">
                <strong>Test Multiplicación (2 puntos)</strong> - Implementar método multiply() correctamente
            </div>
            <div class="test-result passed">
                <strong>Test División (2 puntos)</strong> - Implementar método divide() correctamente
            </div>
            <div class="test-result passed">
                <strong>Test División por Cero (2 puntos)</strong> - Manejar excepciones apropiadamente
            </div>
            <div class="test-result passed">
                <strong>Tests con Data Provider (5 puntos)</strong> - Funcionar con casos múltiples
            </div>
            <div class="test-result passed">
                <strong>Verificación PSR-12 (3 puntos)</strong> - Cumplir estándares de código
            </div>
            <div class="test-result passed">
                <strong>Análisis Estático (3 puntos)</strong> - Código libre de errores detectables
            </div>
            <div class="test-result passed">
                <strong>Verificación Final (4 puntos)</strong> - Todos los tests pasan correctamente
            </div>
            <?php
        }
        ?>
       
        <h2 id="view-results">Resultados</h2>
        <div id="results">
            <p>Haz clic en "Ejecutar Autograding" para ver los resultados de evaluación.</p>
        </div>

        <h2>💡 Tips para Estudiantes</h2>
        <div style="background: #fff3cd; color: #856404; padding: 15px; border-radius: 4px;">
            <ul>
                <li>📝 <strong>Lee los tests:</strong> Entiende qué se espera de cada método</li>
                <li>🔄 <strong>Ejecuta tests frecuentemente:</strong> Usa `composer test` para verificar progreso</li>
                <li>🎨 <strong>Cuida el estilo:</strong> Usa `composer style-fix` para corregir formato</li>
                <li>🔍 <strong>Analiza el código:</strong> Usa `composer analyze` para detectar problemas</li>
                <li>📋 <strong>Commit frecuentemente:</strong> El autograding se ejecuta en cada push</li>
            </ul>
        </div>

        <h2>📚 Recursos de Ayuda</h2>
        <div style="background: #f8f9fa; padding: 15px; border-radius: 4px;">
            <ul>
                <li><strong>Documentación PHP:</strong> <a href="https://www.php.net/manual/" target="_blank">php.net/manual</a></li>
                <li><strong>PSR-12 Standard:</strong> <a href="https://www.php-fig.org/psr/psr-12/" target="_blank">php-fig.org/psr/psr-12</a></li>
                <li><strong>PHPUnit Docs:</strong> <a href="https://phpunit.de/documentation.html" target="_blank">phpunit.de/documentation</a></li>
                <li><strong>GitHub Classroom:</strong> Ver resultados en la pestaña "Actions" de tu repositorio</li>
            </ul>
        </div>
    </div>
</body>
</html>

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
         <a href="autograding-report.php" class="btn">Ver Informe de Autograding</a>
        <a href="index.php" class="btn">← Volver al Inicio</a>
        
        <h2>Resultados</h2>
        <div id="results">
            <p>Haz clic en "Ejecutar Tests" para ver los resultados.</p>
        </div>
    </div>
</body>
</html>

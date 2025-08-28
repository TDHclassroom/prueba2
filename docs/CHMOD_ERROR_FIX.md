# 🔧 Solución: Error chmod() Operation not permitted

## 📋 Problema identificado

El error `chmod(): Operation not permitted` en `/workspaces/prueba2/public/run-autograding.php` línea 32 se debía a varios problemas:

1. **Propiedad de archivos**: Los scripts en `/scripts/` pertenecían a `root`, pero PHP ejecuta como `vscode`
2. **Terminaciones de línea CRLF**: Los scripts shell tenían terminaciones de Windows
3. **Dependencias faltantes**: El script `secure-grading-report.sh` requería `bc`
4. **Comando `composer autograding` inexistente**

## 🔧 Soluciones implementadas

### 1. Cambio de propiedad de archivos

```bash
sudo chown -R vscode:vscode /workspaces/prueba2/scripts/
```

### 2. Corrección de terminaciones de línea en scripts shell

```bash
find /workspaces/prueba2/scripts -name "*.sh" -exec sed -i 's/\r$//' {} \;
```

### 3. Instalación de dependencias del sistema

```bash
sudo apt update && sudo apt install -y bc
```

### 4. Comando `composer autograding` agregado

```json
{
  "scripts": {
    "autograding": "@php -r \"exec('./scripts/secure-grading-report.sh 2>&1', \\$output, \\$return); echo implode(PHP_EOL, \\$output);\""
  }
}
```

### 5. Mejora del código PHP para manejo de permisos

```php
// Verificar si el script ya es ejecutable
$isExecutable = is_executable($scriptToUse);

// Solo intentar chmod si no es ejecutable
if (!$isExecutable) {
    // Suprimir errores de chmod y usar @ para evitar warnings
    $chmodSuccess = @chmod($scriptToUse, 0755);
    $isExecutable = is_executable($scriptToUse);
} else {
    $chmodSuccess = true; // Ya es ejecutable, no necesita chmod
}
```

## 🛠️ Scripts de automatización creados

### `scripts/fix-shell-scripts.sh`

- Corrige terminaciones de línea CRLF en scripts shell
- Asegura permisos ejecutables
- Verifica dependencias del sistema

### Integración en Dockerfile

```dockerfile
# Instala bc como dependencia
RUN apt-get install -y bc

# Corrige scripts automáticamente
RUN find scripts -name "*.sh" -exec sed -i 's/\r$//' {} \; 2>/dev/null || true \
    && find scripts -name "*.sh" -exec chmod +x {} \; 2>/dev/null || true
```

### Comandos del docker-helper

```bash
./docker-helper.sh fix-shell-scripts  # Corrige scripts shell
./docker-helper.sh autograding        # Ejecuta autograding
```

## ✅ Resultado

### Autograding funcionando correctamente:

- ✅ Sin errores de `chmod()`
- ✅ Scripts ejecutables correctamente
- ✅ Todas las dependencias instaladas
- ✅ Comando `composer autograding` disponible
- ✅ Interfaz web funcional sin errores

### Puntuación de tests:

```
Puntuación: 1.38/2.28 (60.53%)
Tests pasados: 7/8 (falta corrección de estilo PSR-12)
```

## 🔄 Prevención futura

### Scripts automáticos

1. **`fix-line-endings.sh`**: Corrige vendor/bin después de `composer install/update`
2. **`fix-shell-scripts.sh`**: Corrige scripts shell tras clonar/actualizar
3. **Dockerfile**: Incluye correcciones automáticas en build
4. **docker-helper.sh**: Comandos fáciles para correcciones manuales

### Monitoreo

```bash
# Verificar scripts con CRLF
find scripts -name "*.sh" -exec file {} \; | grep CRLF

# Verificar permisos
ls -la scripts/

# Probar autograding
composer autograding
```

## 📝 Comandos útiles

```bash
# Corrección manual completa
sudo chown -R vscode:vscode scripts/
find scripts -name "*.sh" -exec sed -i 's/\r$//' {} \;
find scripts -name "*.sh" -exec chmod +x {} \;

# Ejecutar autograding
composer autograding
./scripts/secure-grading-report.sh

# Docker helper
./docker-helper.sh fix-shell-scripts
./docker-helper.sh autograding
```

## 🎯 Estado actual

- **Autograding**: ✅ Completamente funcional
- **Interfaz web**: ✅ Sin errores PHP
- **Scripts shell**: ✅ Ejecutables con terminaciones Unix
- **Dependencias**: ✅ Todas instaladas (bc, php, composer)
- **Permisos**: ✅ Propietario correcto (vscode:vscode)
- **Docker ready**: ✅ Configuración incluida en Dockerfile

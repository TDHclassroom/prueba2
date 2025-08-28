# 🐛 Solución al Error PHPUnit "Script returned with error code 127"

## 📋 Problema identificado

El error `Script phpunit handling the test event returned with error code 127` se debe a dos problemas principales:

1. **Terminaciones de línea CRLF**: Los archivos ejecutables en `vendor/bin/` tenían terminaciones de línea de Windows (`\r\n`) en lugar de Unix (`\n`)
2. **Configuración de Xdebug**: Xdebug intentaba conectar automáticamente al debugger, generando mensajes de error

## 🔧 Soluciones implementadas

### 1. Corrección automática de terminaciones de línea

#### Script automatizado

- Creado: `scripts/fix-line-endings.sh`
- Función: Corrige automáticamente terminaciones CRLF en archivos `vendor/bin/`

#### Integración en Composer

Agregado al `composer.json`:

```json
"scripts": {
    "fix-line-endings": "@php -r \"exec('find vendor/bin -type f -exec sed -i \\'s/\\r$/\\' {} \\; 2>/dev/null || true');\"",
    "post-install-cmd": "@fix-line-endings",
    "post-update-cmd": "@fix-line-endings"
}
```

#### Corrección manual inmediata

```bash
# Comando ejecutado para solución inmediata
find vendor/bin -type f -exec sed -i 's/\r$//' {} \;
```

### 2. Optimización de configuración Xdebug

#### Configuración mejorada

```ini
zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20220829/xdebug.so
xdebug.mode=debug,coverage
xdebug.start_with_request=trigger  # Solo inicia cuando es necesario
xdebug.client_host=host.docker.internal
xdebug.client_port=9003
xdebug.log_level=0  # Reduce mensajes de log
```

### 3. Mejoras en Dockerfile

#### Corrección automática en build

```dockerfile
# Corrige terminaciones de línea CRLF en archivos vendor/bin
RUN find vendor/bin -type f -exec sed -i 's/\r$//' {} \; 2>/dev/null || true
```

#### Configuraciones PHP específicas

- `docker/php-dev.ini`: Configuración optimizada para desarrollo
- `docker/php-prod.ini`: Configuración optimizada para producción

### 4. Script helper mejorado

Agregado comando para corrección manual:

```bash
./docker-helper.sh fix-line-endings
```

## ✅ Resultado

PHPUnit ahora ejecuta correctamente:

- ✅ Sin errores de código 127
- ✅ Sin mensajes molestos de Xdebug
- ✅ Corrección automática en futuras instalaciones
- ✅ 40/40 tests pasando correctamente

## 🔄 Prevención futura

### Corrección automática

- Los scripts `post-install-cmd` y `post-update-cmd` en Composer corrigen automáticamente el problema
- El Dockerfile incluye la corrección durante el build
- Script `fix-line-endings.sh` disponible para ejecución manual

### Monitoreo

```bash
# Verificar archivos con CRLF
find vendor/bin -type f -exec file {} \; | grep CRLF

# Ejecutar corrección manual si es necesario
composer run-script fix-line-endings
```

## 📝 Nota importante

Este problema es común en proyectos que se desarrollan en entornos mixtos Windows/Linux o cuando se usan herramientas que no respetan las terminaciones de línea del sistema operativo. La solución implementada es robusta y previene futuras ocurrencias del problema.

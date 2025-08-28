# 🐛 Guía de Solución de Problemas

## 📋 Error PHPUnit "Script returned with error code 127"

### Problema identificado

El error `Script phpunit handling the test event returned with error code 127` se debe a dos problemas principales:

1. **Terminaciones de línea CRLF**: Los archivos ejecutables en `vendor/bin/` tenían terminaciones de línea de Windows (`\r\n`) en lugar de Unix (`\n`)
2. **Configuración de Xdebug**: Xdebug intentaba conectar automáticamente al debugger, generando mensajes de error

### Soluciones implementadas

#### 1. Corrección automática de terminaciones de línea

**Script automatizado**

- Creado: `scripts/fix-line-endings.sh`
- Función: Corrige automáticamente terminaciones CRLF en archivos `vendor/bin/`

**Integración en Composer**
Agregado al `composer.json`:

```json
"scripts": {
    "fix-line-endings": "@php -r \"exec('find vendor/bin -type f -exec sed -i \\'s/\\r$/\\' {} \\; 2>/dev/null || true');\"",
    "post-install-cmd": "@fix-line-endings",
    "post-update-cmd": "@fix-line-endings"
}
```

**Corrección manual inmediata**

```bash
# Comando ejecutado para solución inmediata
find vendor/bin -type f -exec sed -i 's/\r$//' {} \;
```

#### 2. Optimización de configuración Xdebug

**Configuración mejorada**

```ini
zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20220829/xdebug.so
xdebug.mode=debug,coverage
xdebug.start_with_request=trigger  # Solo inicia cuando es necesario
xdebug.client_host=host.docker.internal
xdebug.client_port=9003
xdebug.log_level=0  # Reduce mensajes de log
```

### Resultado

PHPUnit ahora ejecuta correctamente:

- ✅ Sin errores de código 127
- ✅ Sin mensajes molestos de Xdebug
- ✅ Corrección automática en futuras instalaciones
- ✅ 40/40 tests pasando correctamente

---

## 🌐 Problema: Servidor no accesible desde navegador host

### Problema identificado

El servidor PHP no era accesible desde el navegador del host porque estaba configurado para escuchar solo en `localhost` (127.0.0.1).

### Solución implementada

**Cambio en composer.json**

```json
// Antes
"serve": "php -S localhost:8000 -t public"

// Después
"serve": "php -S 0.0.0.0:8000 -t public"
```

### Resultado

- ✅ Servidor accesible desde navegador host
- ✅ Compatible con contenedores Docker
- ✅ Funciona en todas las interfaces de red

**Verificación:**

```bash
$ netstat -tlnp | grep :8000
tcp  0  0  0.0.0.0:8000  0.0.0.0:*  LISTEN
```

**Acceso:**

- Local: `http://localhost:8000` ✅
- Host: `http://0.0.0.0:8000` ✅

---

## 🔄 Prevención futura

### Corrección automática

- Los scripts `post-install-cmd` y `post-update-cmd` en Composer corrigen automáticamente el problema de terminaciones de línea
- El Dockerfile incluye la corrección durante el build
- Script `fix-line-endings.sh` disponible para ejecución manual

### Monitoreo

```bash
# Verificar archivos con CRLF
find vendor/bin -type f -exec file {} \; | grep CRLF

# Ejecutar corrección manual si es necesario
composer run-script fix-line-endings

# Verificar servidor
netstat -tlnp | grep :8000
```

### Comandos útiles

```bash
# Iniciar servidor
composer serve

# Ejecutar tests
composer test

# Análisis de código
composer analyze

# Docker helper
./docker-helper.sh dev
./docker-helper.sh fix-line-endings
```

## 📝 Notas importantes

1. **Terminaciones de línea**: Problema común en entornos mixtos Windows/Linux
2. **Servidor binding**: `0.0.0.0` es necesario para acceso externo y contenedores
3. **Xdebug**: Configurado para activación manual (`trigger`) para mejor rendimiento
4. **Docker**: Todas las configuraciones son compatibles con contenedores

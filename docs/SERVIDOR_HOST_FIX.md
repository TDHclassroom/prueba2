# 🌐 Solución: Acceso al Servidor desde el Navegador Host

## 📋 Problema identificado

El servidor PHP integrado no era accesible desde el navegador del host debido a que estaba configurado para escuchar solo en `localhost` (127.0.0.1).

### Síntomas:

- El servidor iniciaba correctamente
- `curl` local funcionaba
- Navegador del host no podía conectar al puerto 8000
- `netstat` mostraba `tcp6  0  0  ::1:8000  :::*  LISTEN` (solo IPv6 local)

## 🔧 Solución implementada

### Cambio en composer.json

**Antes:**

```json
"serve": "php -S localhost:8000 -t public"
```

**Después:**

```json
"serve": "php -S 0.0.0.0:8000 -t public"
```

### Verificación de la solución

1. **Estado del puerto después del cambio:**

   ```bash
   $ netstat -tlnp | grep :8000
   tcp  0  0  0.0.0.0:8000  0.0.0.0:*  LISTEN  4283/php
   ```

2. **Servidor ahora escucha en todas las interfaces:**
   ```bash
   $ curl -I http://0.0.0.0:8000
   HTTP/1.1 200 OK
   Host: 0.0.0.0:8000
   Date: Wed, 27 Aug 2025 15:25:22 GMT
   Connection: close
   X-Powered-By: PHP/8.2.29
   Content-type: text/html; charset=UTF-8
   ```

## 🌐 Acceso desde el host

Ahora el servidor es accesible desde:

- **Local**: `http://localhost:8000`
- **Host**: `http://0.0.0.0:8000`
- **Red**: `http://[IP-DEL-CONTENEDOR]:8000`

## 🐳 Implicaciones para Docker

### En desarrollo local (sin Docker):

- ✅ Funciona correctamente
- ✅ Accesible desde navegador del host

### Con Docker:

- ✅ Necesario mapear puertos en docker-compose.yml
- ✅ Configurar `0.0.0.0:8000` para acceso externo al contenedor
- ✅ Puerto mapping: `"8000:8000"`

### Ejemplo docker-compose.yml:

```yaml
services:
  web:
    ports:
      - "8000:80" # Para Apache
      # O para servidor PHP integrado:
      - "8000:8000"
    command: composer serve # Ahora usa 0.0.0.0:8000
```

## 🛠️ Comandos útiles para debugging

```bash
# Verificar puertos en uso
netstat -tlnp | grep :8000

# Verificar procesos PHP
ps aux | grep "php -S"

# Probar conectividad local
curl -I http://localhost:8000
curl -I http://0.0.0.0:8000

# Ver logs del servidor en tiempo real
composer serve  # En primer plano
```

## ✅ Estado actual

- **Servidor**: ✅ Funcionando en `0.0.0.0:8000`
- **Acceso local**: ✅ `http://localhost:8000`
- **Acceso host**: ✅ Disponible
- **Docker ready**: ✅ Configuración compatible

## 📝 Notas importantes

1. **Seguridad**: En producción, considerar usar un servidor web real (Apache/Nginx)
2. **Performance**: El servidor PHP integrado es solo para desarrollo
3. **Docker**: El cambio a `0.0.0.0` es esencial para contenedores
4. **Firewall**: Asegurarse de que el puerto 8000 esté abierto si es necesario

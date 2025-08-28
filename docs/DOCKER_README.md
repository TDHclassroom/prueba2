# 🐳 Docker Setup para PHP Testing Environment

Este documento explica cómo usar Docker para ejecutar el entorno de testing PHP.

## 📋 Prerequisitos

- Docker instalado
- Docker Compose instalado

## 🚀 Inicio Rápido

### Opción 1: Desarrollo (con Xdebug y herramientas de desarrollo)

```bash
# Construir y levantar los servicios
docker-compose -f docker-compose.dev.yml up --build

# En segundo plano
docker-compose -f docker-compose.dev.yml up -d --build
```

### Opción 2: Producción (optimizado)

```bash
# Construir para producción
docker-compose up --build

# En segundo plano
docker-compose up -d --build
```

## 🔧 Comandos Útiles

### Gestión de contenedores

```bash
# Ver contenedores en ejecución
docker-compose ps

# Detener servicios
docker-compose down

# Ver logs
docker-compose logs web
docker-compose logs -f web  # seguir logs en tiempo real
```

### Ejecutar comandos dentro del contenedor

```bash
# Acceder al shell del contenedor
docker-compose exec web bash

# Ejecutar tests
docker-compose exec web composer test

# Ejecutar análisis de código
docker-compose exec web composer analyze

# Verificar estilo de código
docker-compose exec web composer style-check

# Corregir estilo de código
docker-compose exec web composer style-fix
```

### Usando el servicio CLI

```bash
# Activar el perfil CLI
docker-compose --profile cli up -d php-cli

# Ejecutar comandos PHP CLI
docker-compose exec php-cli php -v
docker-compose exec php-cli composer test
docker-compose exec php-cli phpunit --testdox
```

## 🌐 Acceso a la aplicación

- **Aplicación web**: http://localhost:8000
- **MailHog (solo en desarrollo)**: http://localhost:8025

## 🐛 Debug con Xdebug

Para usar Xdebug con VS Code:

1. Instala la extensión "PHP Debug"
2. Configura VS Code con este `launch.json`:

```json
{
  "version": "0.2.0",
  "configurations": [
    {
      "name": "Listen for Xdebug",
      "type": "php",
      "request": "launch",
      "port": 9003,
      "pathMappings": {
        "/var/www/html": "${workspaceFolder}"
      }
    }
  ]
}
```

3. Inicia el debugging en VS Code
4. Los breakpoints funcionarán automáticamente

## 📁 Estructura de archivos Docker

```
├── Dockerfile                 # Dockerfile multi-stage
├── docker-compose.yml         # Configuración básica
├── docker-compose.dev.yml     # Configuración de desarrollo
└── .dockerignore             # Archivos ignorados en build
```

## 🔄 Desarrollo con Hot Reload

Los archivos están montados como volúmenes, por lo que los cambios se reflejan inmediatamente sin necesidad de reconstruir la imagen.

## 📦 Construcción manual de imágenes

```bash
# Construir imagen de desarrollo
docker build --target development -t php-testing-dev .

# Construir imagen de producción
docker build --target production -t php-testing-prod .

# Ejecutar imagen manualmente
docker run -p 8000:80 -v $(pwd):/var/www/html php-testing-dev
```

## 🧹 Limpieza

```bash
# Eliminar contenedores y redes
docker-compose down

# Eliminar también volúmenes
docker-compose down -v

# Limpiar imágenes no utilizadas
docker system prune -a
```

## 🛠️ Troubleshooting

### El contenedor no inicia

- Verifica que el puerto 8000 no esté siendo usado por otro proceso
- Revisa los logs con `docker-compose logs web`

### Problemas con permisos

```bash
# Corregir permisos en el contenedor
docker-compose exec web chown -R www-data:www-data /var/www/html
```

### Xdebug no funciona

- Asegúrate de que tu IDE esté configurado para escuchar en el puerto 9003
- Verifica que `host.docker.internal` resuelva correctamente

### Dependencias no instaladas

```bash
# Reinstalar dependencias
docker-compose exec web composer install
```

## 📝 Notas adicionales

- La configuración de desarrollo incluye MailHog para testing de emails
- Los logs de Apache se almacenan en `./logs/`
- Las dependencias de Composer se cachean en un volumen para mejorar el rendimiento
- El contenedor usa PHP 8.2 con todas las extensiones necesarias

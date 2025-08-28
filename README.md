
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
Servidor/
├── .devcontainer/          # Configuración del devcontainer 
├── exercises/              # 📝 Realizar ejercicios aquí
├── tasks/                  # 📝 Requerimientos de ejercicios
├── tests/                  # 🧪 Tests automáticos
├── public/                 # 🌐 Archivos web públicos
├── vendor/                 # 📦 Dependencias de Composer
├── phpunit.xml             # ⚙️ Configuración de PHPUnit
├── composer.json           # 📋 Dependencias del proyecto
└── README.md               # 📚 Este archivo
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

### 2. Comandos Útiles

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
2. **Testing**: Estudiante jecuta tests y verifica resultados
3. **Feedback**: Resultados visibles en tiempo real con resultados estimados.

## ⚙️ Configuración Avanzada

### Composer Scripts
- `test`: Ejecuta PHPUnit básico
- `test-watch`: PHPUnit con formato detallado  
- `analyze`: PHPStan level 8
- `style-check`: PHP_CodeSniffer PSR-12
- `style-fix`: PHP_CodeBulkFixer automático
- `serve`: Servidor PHP en puerto 8000

## 🐛 Soluciones rápidas a problemas

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
sudo chmod -R 755 
```

## 📚 Recursos Adicionales

- [Documentación PHPUnit](https://phpunit.de/documentation.html)
- [PSR-12 Coding Standard](https://www.php-fig.org/psr/psr-12/)
- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [Composer Documentation](https://getcomposer.org/doc/)

---

✨ **¡Listo para empezar a programar y probar en PHP!** ✨

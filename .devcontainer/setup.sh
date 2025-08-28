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

# Instalar dependencias del proyecto
echo "📚 Instalando dependencias del proyecto..."
cd $PROJECT_ROOT
composer install

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

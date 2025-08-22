#!/bin/bash

# Script de preparación del entorno para estudiantes
# Instala todas las dependencias necesarias para el sistema de autograding
# Uso: ./scripts/setup-student-environment.sh

set -euo pipefail

echo "🎓 Preparando entorno para estudiantes..."
echo "========================================"

# Detectar el sistema operativo
detect_os() {
    if [ -f /etc/os-release ]; then
        . /etc/os-release
        OS=$ID
        VERSION=$VERSION_ID
    elif command -v lsb_release >/dev/null 2>&1; then
        OS=$(lsb_release -si | tr '[:upper:]' '[:lower:]')
        VERSION=$(lsb_release -sr)
    else
        OS="unknown"
        VERSION="unknown"
    fi
}

# Instalar dependencias según el sistema
install_dependencies() {
    local deps=("jq" "bc" "curl" "git")
    local missing_deps=()
    
    # Verificar qué dependencias faltan
    for dep in "${deps[@]}"; do
        if ! command -v "$dep" >/dev/null 2>&1; then
            missing_deps+=("$dep")
        fi
    done
    
    if [ ${#missing_deps[@]} -eq 0 ]; then
        echo "✅ Todas las dependencias están instaladas"
        return 0
    fi
    
    echo "📦 Instalando dependencias: ${missing_deps[*]}"
    
    case "$OS" in
        ubuntu|debian)
            echo "🐧 Detectado: Ubuntu/Debian"
            if ! sudo apt-get update >/dev/null 2>&1; then
                echo "⚠️ No se pudo actualizar la lista de paquetes"
            fi
            
            if sudo apt-get install -y "${missing_deps[@]}" >/dev/null 2>&1; then
                echo "✅ Dependencias instaladas exitosamente"
            else
                echo "❌ Error instalando dependencias en Ubuntu/Debian"
                return 1
            fi
            ;;
        alpine)
            echo "🏔️ Detectado: Alpine Linux"
            if ! sudo apk update >/dev/null 2>&1; then
                echo "⚠️ No se pudo actualizar la lista de paquetes"
            fi
            
            if sudo apk add "${missing_deps[@]}" >/dev/null 2>&1; then
                echo "✅ Dependencias instaladas exitosamente"
            else
                echo "❌ Error instalando dependencias en Alpine"
                return 1
            fi
            ;;
        centos|rhel|fedora)
            echo "🎩 Detectado: CentOS/RHEL/Fedora"
            local pkg_manager="yum"
            command -v dnf >/dev/null 2>&1 && pkg_manager="dnf"
            
            if sudo "$pkg_manager" install -y "${missing_deps[@]}" >/dev/null 2>&1; then
                echo "✅ Dependencias instaladas exitosamente"
            else
                echo "❌ Error instalando dependencias en CentOS/RHEL"
                return 1
            fi
            ;;
        *)
            echo "❓ Sistema operativo no reconocido: $OS"
            echo "💡 Instala manualmente:"
            for dep in "${missing_deps[@]}"; do
                echo "   - $dep"
            done
            return 1
            ;;
    esac
    
    # Verificar que las dependencias se instalaron
    for dep in "${missing_deps[@]}"; do
        if ! command -v "$dep" >/dev/null 2>&1; then
            echo "❌ Error: $dep no se instaló correctamente"
            return 1
        fi
    done
}

# Instalar dependencias de PHP (Composer)
setup_php_environment() {
    echo ""
    echo "🐘 Configurando entorno PHP..."
    
    # Verificar que PHP está instalado
    if ! command -v php >/dev/null 2>&1; then
        echo "❌ PHP no está instalado. Instálalo primero:"
        case "$OS" in
            ubuntu|debian)
                echo "   sudo apt install -y php php-cli php-mbstring php-xml php-json"
                ;;
            alpine)
                echo "   sudo apk add php php-cli php-mbstring php-xml php-json"
                ;;
            centos|rhel|fedora)
                echo "   sudo yum install -y php php-cli php-mbstring php-xml php-json"
                ;;
        esac
        return 1
    fi
    
    echo "✅ PHP $(php -d xdebug.mode=off -r 'echo PHP_VERSION;') detectado"
    
    # Verificar/instalar Composer
    if ! command -v composer >/dev/null 2>&1; then
        echo "📦 Instalando Composer..."
        
        # Descargar e instalar Composer
        if curl -sS https://getcomposer.org/installer | php -d xdebug.mode=off >/dev/null 2>&1; then
            sudo mv composer.phar /usr/local/bin/composer
            sudo chmod +x /usr/local/bin/composer
            echo "✅ Composer instalado exitosamente"
        else
            echo "❌ Error instalando Composer"
            return 1
        fi
    else
        echo "✅ Composer $(XDEBUG_MODE=off composer --version --no-ansi | head -1) detectado"
    fi
    
    # Instalar dependencias del proyecto
    if [ -f "composer.json" ]; then
        echo "📦 Instalando dependencias del proyecto..."
        if XDEBUG_MODE=off composer install >/dev/null 2>&1; then
            echo "✅ Dependencias PHP instaladas"
        else
            echo "⚠️ Error instalando dependencias PHP"
            echo "💡 Ejecuta manualmente: composer install"
        fi
    fi
}

# Verificar el entorno de desarrollo
verify_environment() {
    echo ""
    echo "🔍 Verificando entorno..."
    
    local checks_passed=0
    local total_checks=6
    
    # Verificar PHP
    if command -v php >/dev/null 2>&1; then
        echo "✅ PHP: $(php -d xdebug.mode=off -r 'echo PHP_VERSION;')"
        ((checks_passed++))
    else
        echo "❌ PHP: No encontrado"
    fi
    
    # Verificar Composer
    if command -v composer >/dev/null 2>&1; then
        echo "✅ Composer: Instalado"
        ((checks_passed++))
    else
        echo "❌ Composer: No encontrado"
    fi
    
    # Verificar jq
    if command -v jq >/dev/null 2>&1; then
        echo "✅ jq: $(jq --version)"
        ((checks_passed++))
    else
        echo "❌ jq: No encontrado"
    fi
    
    # Verificar bc
    if command -v bc >/dev/null 2>&1; then
        echo "✅ bc: Instalado"
        ((checks_passed++))
    else
        echo "❌ bc: No encontrado"
    fi
    
    # Verificar PHPUnit
    if [ -f "vendor/bin/phpunit" ]; then
        echo "✅ PHPUnit: Instalado"
        ((checks_passed++))
    else
        echo "❌ PHPUnit: No encontrado (ejecuta 'composer install')"
    fi
    
    # Verificar configuración de autograding
    if [ -f ".github/classroom/autograding.json" ]; then
        echo "✅ Configuración de autograding: Encontrada"
        ((checks_passed++))
    else
        echo "❌ Configuración de autograding: No encontrada"
    fi
    
    echo ""
    echo "📊 Resumen: $checks_passed/$total_checks verificaciones pasaron"
    
    if [ $checks_passed -eq $total_checks ]; then
        echo "🎉 ¡Entorno completamente configurado y listo!"
        return 0
    else
        echo "⚠️ Algunas verificaciones fallaron. Revisa los errores arriba."
        return 1
    fi
}

# Mostrar comandos útiles
show_usage_info() {
    echo ""
    echo "🚀 Comandos útiles para el desarrollo:"
    echo "======================================"
    echo ""
    echo "📋 Testing:"
    echo "  composer test              # Ejecutar todos los tests"
    echo "  composer test-watch        # Tests con output detallado"
    echo ""
    echo "📊 Autograding:"
    echo "  ./scripts/generate-grading-report.sh    # Generar reporte"
    echo "  ./scripts/manage-autograding.sh list    # Ver configuración"
    echo ""
    echo "🔧 Herramientas:"
    echo "  composer serve             # Servidor de desarrollo"
    echo "  composer analyze           # Análisis estático"
    echo "  composer style-check       # Verificar estilo de código"
    echo ""
}

# Función principal
main() {
    detect_os
    echo "🖥️ Sistema detectado: $OS $VERSION"
    echo ""
    
    if ! install_dependencies; then
        echo ""
        echo "❌ No se pudieron instalar todas las dependencias del sistema"
        echo "💡 Instala manualmente e intenta de nuevo"
        exit 1
    fi
    
    if ! setup_php_environment; then
        echo ""
        echo "❌ No se pudo configurar el entorno PHP completamente"
        echo "💡 Revisa los errores arriba"
        exit 1
    fi
    
    if verify_environment; then
        show_usage_info
        echo ""
        echo "✅ ¡Configuración completa! El entorno está listo para usar."
    else
        echo ""
        echo "⚠️ La configuración se completó con algunas advertencias."
        echo "💡 El entorno debería funcionar, pero revisa los elementos faltantes."
    fi
}

# Ejecutar solo si se llama directamente
if [[ "${BASH_SOURCE[0]}" == "${0}" ]]; then
    main "$@"
fi

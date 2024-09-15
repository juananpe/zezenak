# Aplicación de Gestión de Ganadería

## Descripción
Esta aplicación web permite gestionar información básica sobre una ganadería de toros. Está desarrollada en PHP y utiliza una base de datos MariaDB para almacenar los datos. La aplicación se ejecuta en un entorno Docker, lo que facilita su despliegue y ejecución en diferentes sistemas.

⚠️ **ADVERTENCIA**: Esta aplicación contiene vulnerabilidades de seguridad intencionales. NO debe utilizarse en un entorno de producción ni exponerse a Internet.

## Vulnerabilidades Incluidas
Esta aplicación incluye, pero no se limita a, las siguientes vulnerabilidades:
- Inyección SQL
- Cross-Site Scripting (XSS)
- Autenticación y gestión de sesiones débiles
- Exposición de datos sensibles
- File upload vulnerabilitie (RCE)

## Requisitos
- Docker
- Docker Compose

## Estructura del Proyecto
- `index.php`: Página principal de la aplicación
- `kudeatu.php`: Script para la gestión de toros
- `babeskopia.sql`: Archivo SQL con la estructura y datos iniciales de la base de datos
- `docker-compose.yml`: Archivo de configuración de Docker Compose
- `Dockerfile-php`: Dockerfile para la imagen de PHP personalizada
- `nginx.conf`: Configuración de Nginx

## Instalación y Ejecución

1. Clona este repositorio en tu máquina local:
   ```
   git clone [URL_DEL_REPOSITORIO]
   ```

2. Navega al directorio del proyecto:
   ```
   cd [NOMBRE_DEL_DIRECTORIO]
   ```

3. Inicia los contenedores con Docker Compose:
   ```
   docker-compose up -d
   ```
   Nota: puedes omitir la opción -d para poder ver los logs de los contenedores en pantalla

   Esto iniciará los servicios de Nginx, PHP-FPM y MariaDB, y cargará automáticamente los datos iniciales de la base de datos desde `babeskopia.sql`.

4. Accede a la aplicación a través de tu navegador web:
   ```
   http://localhost
   ```

## Detener la Aplicación

Para detener y eliminar los contenedores, ejecuta:
```
docker-compose down
```

## Reiniciar la Base de Datos

Si necesitas reiniciar la base de datos con los datos iniciales:

1. Detén y elimina los contenedores y volúmenes:
   ```
   docker-compose down -v
   ```

2. Vuelve a iniciar los contenedores:
   ```
   docker-compose up -d
   ```

## Desarrollo

- Para hacer cambios en los archivos PHP, simplemente edita los archivos en tu editor preferido. Los cambios se reflejarán inmediatamente debido al montaje de volúmenes.
- Si necesitas instalar extensiones PHP adicionales, modifica el archivo `Dockerfile-php` y reconstruye la imagen con `docker-compose up --build`.

## Notas Adicionales

- El usuario por defecto es 'admin'.
- Para cualquier problema o sugerencia, por favor abre un issue en el repositorio del proyecto.

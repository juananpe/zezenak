# Aplicación de Gestión de Toros

## Descripción
Esta aplicación web permite gestionar información sobre toros. Está desarrollada en PHP y utiliza una base de datos MariaDB para almacenar los datos. La aplicación se ejecuta en un entorno Docker, lo que facilita su despliegue y ejecución en diferentes sistemas.

⚠️ **ADVERTENCIA**: Esta aplicación contiene vulnerabilidades de seguridad intencionales. NO debe utilizarse en un entorno de producción ni exponerse a Internet.

## Vulnerabilidades Incluidas
Esta aplicación incluye, pero no se limita a, las siguientes vulnerabilidades:
- Inyección SQL
- Cross-Site Scripting (XSS)
- Autenticación y gestión de sesiones débiles
- Exposición de datos sensibles

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
- Asegúrate de no exponer información sensible como credenciales de base de datos en entornos de producción.
- Para cualquier problema o sugerencia, por favor abre un issue en el repositorio del proyecto.

```

Este README proporciona una visión general del proyecto, instrucciones de instalación y ejecución, y algunas notas útiles para el desarrollo y mantenimiento. Puedes ajustarlo según las necesidades específicas de tu proyecto o añadir más detalles si lo consideras necesario.


# Construcción y ejecución del proyecto PHP con Docker

## 1. Objetivo

El objetivo de esta práctica es construir una imagen Docker que contenga una aplicación web desarrollada con HTML, CSS y PHP, utilizando Apache como servidor web.

La aplicación permitirá rellenar un formulario de inscripción y visualizar los datos enviados al servidor.

Para realizar la práctica se utilizará la imagen base `php:8.3-apache`, que incluye PHP y Apache configurados para trabajar conjuntamente.

## 2. Estructura del proyecto

Antes de comenzar, comprueba que el proyecto tiene la siguiente estructura:
```text
ejemplo-php/
├── Dockerfile
├── comandos.md
└── html/
    ├── index.html
    ├── procesar.php
    └── estilos.css
```

Descripción de los archivos:

- `Dockerfile`: contiene las instrucciones necesarias para construir la imagen Docker.
- `comandos.md`: documenta los comandos utilizados durante la práctica.
- `html/index.html`: contiene el formulario de inscripción.
- `html/procesar.php`: recibe los datos enviados por el formulario y genera la página de resultados.
- `html/estilos.css`: define el diseño visual de las páginas.

Todos los comandos de esta práctica deben ejecutarse desde el directorio raíz `ejemplo-php/`, salvo que se indique lo contrario.

## 3. Contenido del Dockerfile

Crea un archivo llamado `Dockerfile` con el siguiente contenido:
```dockerfile
# Imagen base con PHP y Apache
FROM php:8.3-apache

# Directorio de trabajo de Apache
WORKDIR /var/www/html

# Copiar el contenido de la carpeta html al servidor web
COPY html/ /var/www/html/

# Puerto utilizado por Apache
EXPOSE 80
```

### Explicación de las instrucciones

- `FROM php:8.3-apache`: utiliza una imagen que incluye PHP 8.3 y Apache.
- `WORKDIR /var/www/html`: establece el directorio de trabajo dentro de la imagen.
- `COPY html/ /var/www/html/`: copia todo el contenido de la carpeta `html` del proyecto al directorio web del contenedor.
- `EXPOSE 80`: documenta que la aplicación utiliza el puerto 80 dentro del contenedor.

La instrucción `COPY` utiliza como origen una ruta relativa al contexto de construcción. En este caso, `html/` se encuentra dentro del directorio desde el que se ejecutará `docker build`.

## 4. Construir la imagen Docker

Desde el directorio raíz del proyecto, ejecuta:
```bash
docker build -t ejemplo-php:v1 .
```

### Explicación del comando

- `docker build`: construye una imagen a partir de un Dockerfile.
- `-t ejemplo-php:v1`: asigna a la imagen el nombre `ejemplo-php` y la etiqueta `v1`.
- `.`: indica que el contexto de construcción es el directorio actual.

El punto final es importante: permite a Docker acceder al `Dockerfile` y a la carpeta `html` durante la construcción.

### Comprobar la imagen creada
```bash
docker images
```

Busca una imagen con el nombre `ejemplo-php` y la etiqueta `v1`.


## 5. Crear y ejecutar el contenedor

Crea un contenedor a partir de la imagen construida:
```bash
docker run -d --name formulario-web -p 8080:80 ejemplo-php:v1
```

### Explicación del comando

- `docker run`: crea un contenedor y lo ejecuta.
- `-d`: ejecuta el contenedor en segundo plano.
- `--name formulario-web`: asigna el nombre `formulario-web` al contenedor.
- `-p 8080:80`: publica el puerto 80 del contenedor en el puerto 8080 del equipo anfitrión.
- `formulario-php:v1`: indica la imagen utilizada para crear el contenedor.

El servidor Apache escucha en el puerto 80 dentro del contenedor. Gracias a la publicación de puertos, se podrá acceder desde el equipo anfitrión a través del puerto 8080.

## 6. Comprobar el estado del contenedor

Para consultar los contenedores que están en ejecución:
```bash
docker ps
```

Busca el contenedor `formulario-web` y comprueba que aparece en estado `Up`.

Para consultar también los contenedores detenidos:
```bash
docker ps -a
```

Para consultar los mensajes generados por Apache y la aplicación:
```bash
docker logs formulario-web
```

Si el contenedor no permanece en ejecución, revisa los mensajes para identificar el problema.

## 7. Probar la aplicación web

Abre un navegador web y accede a la siguiente dirección:
```text
http://localhost:8080
```

Comprueba los siguientes aspectos:

1. Se muestra el formulario de inscripción.
2. Los estilos CSS se aplican correctamente.
3. Es posible introducir el nombre y el correo electrónico.
4. Es posible seleccionar un ciclo formativo y el curso.
5. La casilla para indicar si se dispone de ordenador portátil funciona correctamente.
6. Al enviar el formulario, se muestra una página con los datos recibidos.
7. El enlace para volver al formulario funciona correctamente.

La aplicación procesa los datos en el servidor mediante PHP. Por tanto, no basta con abrir el archivo HTML directamente desde el sistema de archivos: hay que acceder a través del servidor web.

## 8. Detener el contenedor

Cuando termines las pruebas, detén el contenedor:
```bash
docker stop formulario-web
```

Comprueba que ha dejado de ejecutarse:
```bash
docker ps
```

El contenedor seguirá existiendo, pero estará detenido. Para comprobarlo:
```bash
docker ps -a
```

## 10. Volver a iniciar el contenedor

Si quieres volver a ejecutar el mismo contenedor sin crearlo de nuevo:
```bash
docker start formulario-web
```

Comprueba que está en ejecución y vuelve a acceder a `http://localhost:8080`.

## 11. Eliminar el contenedor

Si deseas eliminar el contenedor:
```bash
docker stop formulario-web
docker rm formulario-web
```

El primer comando detiene el contenedor y el segundo lo elimina.

**Importante:** eliminar un contenedor no elimina la imagen a partir de la cual fue creado.

## 12. Eliminar la imagen

Una vez eliminado el contenedor, puedes eliminar la imagen:
```bash
docker rmi formulario-php:v1
```

Comprueba las imágenes disponibles:
```bash
docker images
```

Si la imagen todavía está siendo utilizada por algún contenedor existente, Docker puede impedir su eliminación hasta que se elimine ese contenedor.

## 13. Resumen de comandos

| Operación                        | Comando                                                            |
| -------------------------------- | ------------------------------------------------------------------ |
| Construir la imagen              | `docker build -t formulario-php:v1 .`                              |
| Listar imágenes                  | `docker images`                                                    |
| Inspeccionar la imagen           | `docker image inspect formulario-php:v1`                           |
| Crear y ejecutar el contenedor   | `docker run -d --name formulario-web -p 8080:80 formulario-web`    |
| Listar contenedores en ejecución | `docker ps`                                                        |
| Listar todos los contenedores    | `docker ps -a`                                                     |
| Consultar los registros          | `docker logs formulario-web`                                       |
| Detener el contenedor            | `docker stop formulario-web`                                       |
| Iniciar el contenedor            | `docker start formulario-web`                                      |
| Eliminar el contenedor           | `docker rm formulario-web`                                         |
| Eliminar la imagen               | `docker rmi formulario-php:v1`                                     |

## 14. Conclusión

En este ejemplo se ha construido una imagen Docker a partir de un Dockerfile, se ha creado un contenedor con Apache y PHP y se ha comprobado el funcionamiento de una aplicación web.

La imagen contiene los archivos de la aplicación y el entorno necesario para ejecutarla. El contenedor proporciona una instancia en ejecución de esa imagen, accesible desde el equipo anfitrión mediante la publicación del puerto 8080.
# Práctica Docker: Servidor web con Nginx

## 1. Preparación del entorno

Antes de comenzar, instalaremos las herramientas necesarias para trabajar con el repositorio y comprobar el funcionamiento del servidor.

### 1.1. Instalación de Git y cURL

Git permite descargar repositorios y cURL permite realizar peticiones HTTP al servidor.

    sudo apt-get install git
    sudo apt-get install curl

### 1.2. Limpieza de Docker

Detenemos y eliminamos los contenedores anteriores para evitar posibles conflictos.

    docker stop $(docker ps -a -q)
    docker rm $(docker ps -a -q)

## 2. Descarga de la imagen

Descargamos la imagen de Nginx basada en Alpine Linux, que utilizaremos para ejecutar el servidor web.

    docker pull nginx:alpine

## 3. Ejecución de un contenedor temporal

Creamos y ejecutamos un contenedor temporal publicando el puerto 80 del contenedor en el puerto 8080 de la máquina anfitriona.

    docker run --rm -p 8080:80 nginx:alpine

## 4. Creación y arranque del contenedor

### 4.1. Crear el contenedor

Creamos un contenedor llamado `servidor_web` a partir de la imagen descargada.

    docker create -it -p 8080:80 --name servidor_web nginx:alpine

### 4.2. Iniciar el contenedor

Iniciamos el contenedor para poner en funcionamiento el servidor web.

    docker start servidor_web

## 5. Comprobación del funcionamiento

Comprobamos que el servidor responde mediante una petición HTTP.

    curl localhost:8080

También podemos acceder desde el navegador a la siguiente dirección:

http://localhost:8080

## 6. Copia de la página web

### 6.1. Clonar el repositorio

Descargamos el repositorio que contiene la página HTML que queremos publicar.

    git clone https://github.com/vicgommor/practica_docker.git

### 6.2. Copiar la página al contenedor

Copiamos el archivo HTML al directorio que Nginx utiliza para servir el contenido web.

    docker cp /home/vicgommor/practica_docker/'P01 - Servidor HTML'/HTML/'Hilos en Java · Guía de estudio.html' servidor_web:/usr/share/nginx/html/

## 7. Configuración de la página principal

### 7.1. Acceder al contenedor

Abrimos una terminal dentro del contenedor para modificar los archivos de la web.

    docker exec -it servidor_web sh

### 7.2. Acceder al directorio HTML

Nos situamos en el directorio donde se encuentran los archivos del servidor web.

    cd /usr/share/nginx/html

### 7.3. Eliminar el archivo predeterminado

Eliminamos el índice original de Nginx para sustituirlo por nuestra página.

    rm index.html

### 7.4. Renombrar la página personalizada

Renombramos el archivo HTML como `index.html` para que Nginx lo muestre como página principal.

    mv 'Hilos en Java · Guía de estudio.html' index.html

## 8. Resultado final

Una vez completados los pasos, accedemos a http://localhost:8080 desde el navegador.

Si todo funciona correctamente, se mostrará la página **Hilos en Java · Guía de estudio** en lugar de la página predeterminada de Nginx.
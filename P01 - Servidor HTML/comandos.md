# Práctica Docker: Servidor web con Nginx

## 0. Preparación del entorno

Antes de comenzar, instalaremos las herramientas necesarias para trabajar con el repositorio y comprobar el funcionamiento del servidor.

### 0.1. Instalación de Git y cURL

Git permite descargar repositorios y cURL permite realizar peticiones HTTP al servidor.

    sudo apt-get install git
    sudo apt-get install curl

### 0.2. Limpieza de Docker

Detenemos y eliminamos los contenedores anteriores para evitar posibles conflictos.

    docker stop $(docker ps -a -q)
    docker rm $(docker ps -a -q)

## PASO 1.- Descargar la imagen del servidor web

Descargamos la imagen de Nginx basada en Alpine Linux, que utilizaremos para ejecutar el servidor web.

    docker pull nginx:alpine

## PASO 2.- Prueba rápida con ru

Creamos y ejecutamos un contenedor temporal publicando el puerto 80 del contenedor en el puerto 8080 de la máquina anfitriona.

    docker run --rm -p 8080:80 nginx:alpine

## PASO 3.- Crear contenedor de servidor

### 3.1. Crear el contenedor

Creamos un contenedor llamado `servidor_web` a partir de la imagen descargada.

    docker create -it -p 8080:80 --name servidor_web nginx:alpine

### 3.2. Iniciar el contenedor

Iniciamos el contenedor para poner en funcionamiento el servidor web.

    docker start servidor_web

### 3.4 Comprobación del funcionamiento

Comprobamos que el servidor responde mediante una petición HTTP.

    curl localhost:8080

También podemos acceder desde el navegador a la siguiente dirección:

http://localhost:8080

## PASO 4.- Copiar contenido web

### 4.1. Clonar el repositorio

Descargamos el repositorio que contiene la página HTML que queremos publicar.

    git clone https://github.com/vicgommor/practica_docker.git

### 4.2. Copiar la página al contenedor

Copiamos el archivo HTML al directorio que Nginx utiliza para servir el contenido web.

    docker cp /home/vicgommor/practica_docker/'P01 - Servidor HTML'/HTML/'Hilos en Java · Guía de estudio.html' servidor_web:/usr/share/nginx/html/

## PASO 5.- Ejecutar comandos en el contenedor

### 5.1. Acceder al contenedor

Abrimos una terminal dentro del contenedor para modificar los archivos de la web.

    docker exec -it servidor_web sh

### 5.2. Acceder al directorio HTML

Nos situamos en el directorio donde se encuentran los archivos del servidor web.

    cd /usr/share/nginx/html

### 5.3. Eliminar el archivo predeterminado

Eliminamos el índice original de Nginx para sustituirlo por nuestra página.

    rm index.html

### 5.4. Renombrar la página personalizada

Renombramos el archivo HTML como `index.html` para que Nginx lo muestre como página principal.

    mv 'Hilos en Java · Guía de estudio.html' index.html

## PASO 6.- Comprobar logs

Conecta los logs en modo follow y haz peticiones al servidor para ver como se actualizan.

    docker logs -f web-server

## PASO 7.- Crear imagen propia a partir del contenedor

    docker commit servidor_web vagm/servidor_web:latest


## PASO 8.- Exportar la imagen a un archivo TAR

    docker save -o servidor_web.tar vagm/servidor_web:latest

## PASO 9.- Eliminar imagen local

en este caso he eliminado todas las imagenes

    docker rmi $(docker images -q)

## PASO 10.- Importar imagen desde archivo y levantar servicio

    docker load -i servidor_web.tar
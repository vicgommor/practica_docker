markdown
````
# Práctica Docker: Servidor web con Nginx

## 1. Preparación del entorno

Antes de comenzar, es necesario instalar las herramientas que se utilizarán durante la práctica y preparar el entorno de Docker.

### 1.1. Instalación de Git y cURL

Git permite clonar repositorios y descargar el código fuente de la práctica. cURL se utilizará para comprobar el funcionamiento del servidor web mediante peticiones HTTP.

```bash
sudo apt-get install git
sudo apt-get install curl
````

### 1.2. Limpieza de Docker

Para evitar conflictos con contenedores de prácticas anteriores, se pueden detener y eliminar los contenedores existentes.

bash
```
docker stop $(docker ps -a -q)
docker rm $(docker ps -a -q)
```

Nota: estos comandos afectan a todos los contenedores de Docker, no solamente a los de esta práctica.

## 2. Descarga de la imagen

Se utilizará la imagen `nginx:alpine`, que contiene el servidor web Nginx y está basada en Alpine Linux.

Para descargarla, ejecutamos:

bash
```
docker pull nginx:alpine
```

## 3. Ejecución de un contenedor temporal

Para probar el funcionamiento de Nginx, podemos ejecutar un contenedor temporal:

bash
```
docker run --rm -p 8080:80 nginx:alpine
```

El parámetro `--rm` elimina el contenedor cuando termina su ejecución, mientras que `-p 8080:80` conecta el puerto 8080 de la máquina anfitriona con el puerto 80 del contenedor.

## 4. Creación y arranque del contenedor

### 4.1. Crear el contenedor

Creamos un contenedor llamado `servidor_web` a partir de la imagen descargada:

bash
```
docker create -it -p 8080:80 --name servidor_web nginx:alpine
```

A diferencia del comando anterior, `docker create` crea el contenedor sin iniciarlo.

### 4.2. Iniciar el contenedor

Para poner en marcha el servidor web, ejecutamos:

bash
```
docker start servidor_web
```

## 5. Comprobación del funcionamiento

Una vez iniciado el contenedor, podemos comprobar que el servidor web responde correctamente.

Ejecutamos cURL desde la máquina anfitriona:

bash
```
curl localhost:8080
```

También podemos acceder desde el navegador mediante la dirección:

`http://localhost:8080`

Si todo funciona correctamente, se mostrará la página predeterminada de Nginx.

## 6. Copia de la página web

### 6.1. Clonar el repositorio

Descargamos el repositorio que contiene la página HTML que queremos publicar:

bash
```
git clone https://github.com/vicgommor/practica_docker.git
```

### 6.2. Copiar el archivo al contenedor

Utilizamos `docker cp` para copiar la página HTML desde la máquina anfitriona al directorio web del contenedor.

bash
```
docker cp /home/vicgommor/practica_docker/'P01 - Servidor HTML'/HTML/'Hilos en Java · Guía de estudio.html' servidor_web:/usr/share/nginx/html/
```

## 7. Configuración de la página principal

Para que Nginx muestre nuestra página HTML en lugar de la página predeterminada, debemos sustituir el archivo `index.html`.

### 7.1. Acceder al contenedor

Entramos en la terminal del contenedor:

bash
```
docker exec -it servidor_web sh
```

### 7.2. Acceder al directorio HTML

Una vez dentro, accedemos al directorio donde Nginx almacena los archivos de la página web:

bash
```
cd /usr/share/nginx/html
```

### 7.3. Eliminar el archivo predeterminado

Eliminamos el archivo `index.html` original de Nginx:

bash
```
rm index.html
```

### 7.4. Renombrar la página personalizada

Renombramos el archivo HTML copiado para que Nginx lo reconozca como página principal:

bash
```
mv 'Hilos en Java · Guía de estudio.html' index.html
```

## 8. Resultado final

Una vez realizados todos los pasos, el servidor Nginx estará configurado para mostrar la página HTML personalizada.

Para comprobar el resultado, accedemos desde el navegador a:

`http://localhost:8080`

Si la configuración se ha realizado correctamente, aparecerá la página Hilos en Java · Guía de estudio en lugar de la página predeterminada de Nginx.

```

```
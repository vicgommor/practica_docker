1. previo
    instalar git y curl
        sudo apt-get install git
        sudo apt-get install curl
    limpieza docker
        docker stop $(docker ps -a -q)
        docker rm $(docker ps -a -q)

    descargar imagen
        docker pull nginx:alpine

2. contenedor temporal
    docker run --rm -p 8080:80 nginx:alpine

2.1. crear contenedor 
    docker create -it -p 8080:80 --name servidor_web nginx:alpine 

3. levantar contenedor
    docker start servidor-web

4. comprobar funcionamiento del mapeo de puerto
    curl localhost:8080
    https://localhost:8080

5. copiar la web 
    clonar contenedor en la maquina real
        git clone https://github.com/vicgommor/practica_docker.git
    copiar web del host al contenedor
        


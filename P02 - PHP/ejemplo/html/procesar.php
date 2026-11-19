<?php
// Recoger los datos enviados mediante GET
$nombre = $_GET["nombre"] ?? "";
$correo = $_GET["correo"] ?? "";
$curso = $_GET["curso"] ?? "";
$nivel = $_GET["nivel"] ?? "";

// Las casillas no marcadas no se envían en el formulario
$portatil = isset($_GET["portatil"]);

// Evitar insertar directamente datos del usuario en el HTML
function limpiar($dato) {
    return htmlspecialchars($dato, ENT_QUOTES, "UTF-8");
}

// Traducir el código del curso a un texto descriptivo
$cursos = [
    "ASIR" => "Administración de Sistemas Informáticos en Red",
    "DAM"  => "Desarrollo de Aplicaciones Multiplataforma",
    "DAW"  => "Desarrollo de Aplicaciones Web"
];

$nombreCurso = $cursos[$curso] ?? "No especificado";

// Traducir el nivel a un texto descriptivo
$niveles = [
    "1" => "Primero",
    "2" => "Segundo"
];

$nombreNivel = $niveles[$nivel] ?? "No especificado";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos recibidos</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>

    <div class="contenedor">

        <h1>Datos recibidos</h1>

        <p class="descripcion">
            El servidor ha recibido los datos enviados desde el formulario.
        </p>

        <div class="resultado">

            <div class="dato">
                <span class="etiqueta">Nombre y apellidos:</span>
                <span><?= limpiar($nombre) ?></span>
            </div>

            <div class="dato">
                <span class="etiqueta">Correo electrónico:</span>
                <span><?= limpiar($correo) ?></span>
            </div>

            <div class="dato">
                <span class="etiqueta">Ciclo formativo:</span>
                <span><?= limpiar($nombreCurso) ?></span>
            </div>

            <div class="dato">
                <span class="etiqueta">Curso:</span>
                <span><?= limpiar($nombreNivel) ?></span>
            </div>

            <div class="dato">
                <span class="etiqueta">Ordenador portátil propio:</span>
                <span>
                    <?= $portatil ? "Sí" : "No" ?>
                </span>
            </div>

        </div>

        <div class="botones">
            <a href="index.html" class="boton-enlace">
                Volver al formulario
            </a>
        </div>

        <p class="nota">
            Esta página se ha generado en el servidor mediante PHP.
        </p>

    </div>

</body>
</html>
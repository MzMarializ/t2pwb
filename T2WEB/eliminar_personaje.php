<?php

include('libreria/principal.php');

if (!isset($_GET['id']) || !isset($_GET['cedula'])) {
    plantilla::aplicar();
    echo "<div class='alert alert-danger'>Faltan datos necesarios</div>";
    echo "<a href='index.php' class='btn btn-primary'>Volver</a>";
    exit();
}

$id = $_GET['id'];
$cedula = $_GET['cedula'];

$ruta = 'datos/' . $id . '.json';

if (!is_file($ruta)) {
    plantilla::aplicar();
    echo "<div class='alert alert-danger'>La obra no existe</div>";
    echo "<a href='index.php' class='btn btn-primary'>Volver</a>";
    exit();
}

$json = file_get_contents($ruta);
$obra = json_decode($json);

if (!isset($obra->personajes) || !is_array($obra->personajes)) {
    plantilla::aplicar();
    echo "<div class='alert alert-danger'>La obra no tiene personajes</div>";
    echo "<a href='personajes.php?id=$id' class='btn btn-primary'>Volver</a>";
    exit();
}

$encontrado = false;
$nuevos_personajes = [];

foreach ($obra->personajes as $p) {
    if (!isset($p->cedula)) continue;

    if ($p->cedula == $cedula) {
        $encontrado = true;
        continue; 
    }

    $nuevos_personajes[] = $p;
}


if (!$encontrado) {
    plantilla::aplicar();
    echo "<div class='alert alert-warning'>Personaje no encontrado</div>";
    echo "<a href='personajes.php?id=$id' class='btn btn-primary'>Volver</a>";
    exit();
}


$obra->personajes = $nuevos_personajes;
file_put_contents($ruta, json_encode($obra));

plantilla::aplicar();
echo "<div class='alert alert-success'>Personaje eliminado correctamente</div>";
echo "<a href='personajes.php?id=$id' class='btn btn-primary'>Volver a la obra</a>";

?>

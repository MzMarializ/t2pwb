<?php 
include("libreria/principal.php"); 

$obra = new obra();

if (isset($_GET['id'])) {
    $ruta = 'datos/' . $_GET['id'] . '.json';
    if (is_file($ruta)) {
        $json = file_get_contents($ruta);
        $obra = json_decode($json);
    } else {
        plantilla::aplicar();
        echo "<div class='text-center'><div class='alert alert-danger'> error al cargar la obra</div>";
        echo "<a href='index.php' class='btn btn-primary'> Volver </a></div>";
        exit();
    }
} else {
    plantilla::aplicar();
    echo "<div class='text-center'><div class='alert alert-danger'> error al cargar la obra</div>";
    echo "<a href='index.php' class='btn btn-primary'> Volver </a></div>";
    exit();
}
plantilla::aplicar();
?>

<div class="row">
    <div class="col-md-4">
        <h2><?= $obra->nombre ?></h2>
        <img src ="<?= $obra->foto_url ?>" alt="<?= $obra->nombre ?>" height="200">

        <p><strong>Tipo:</strong> <?= Datos::Tipos_de_Obras()[$obra->tipo] ?></p>
        <p><strong>Autor:</strong> <?= $obra->autor ?></p>
        <p><strong>País:</strong> <?= $obra->pais ?></p>
        <p><strong>Descripción:</strong> <?= $obra->descripcion ?></p>
    </div>

    <div class="col-md-8"> 
        <h2>Personajes</h2>
        <div class="text-end mb-3">
            <a href="agregar_personaje.php?id=<?= $obra->codigo ?>" class="btn btn-primary">Agregar</a>
        </div>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">Foto</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellido</th>
                    <th scope="col">Fecha de nacimiento</th>
                </tr>
            </thead>
            <tbody>
<?php
foreach($obra->personajes as $personaje){
    echo "
    <tr>
        <td>
            <img src='{$personaje->foto_url}' alt='{$personaje->nombre}' height='100'>
        </td>
        <td>{$personaje->nombre}</td>
        <td>{$personaje->apellido}</td>
        <td>{$personaje->fecha_nacimiento}</td>
        <td>
            <a href='editar_personaje.php?id={$obra->codigo}&cedula={$personaje->cedula}' class='btn btn-warning btn-sm me-2'>Editar</a>
            <a href='eliminar_personaje.php?id={$obra->codigo}&cedula={$personaje->cedula}' class='btn btn-danger btn-sm'>Eliminar</a>
        </td>
    </tr>";
}
?>



            </tbody>
        </table>
    </div>
</div>

<?php 
include("libreria/principal.php"); 

$obra = new Obra();
$personaje = null;

if (isset($_GET['id']) && isset($_GET['cedula'])) {
    $ruta = 'datos/' . $_GET['id'] . '.json';
    if (is_file($ruta)) {
        $json = file_get_contents($ruta);
        $obra = json_decode($json);
    } else {
        plantilla::aplicar();
        echo "<div class='alert alert-danger'>Error al cargar la obra</div>";
        echo "<a href='index.php' class='btn btn-primary'>Volver</a>";
        exit();
    }

    foreach ($obra->personajes as $p) {
        if ($p->cedula == $_GET['cedula']) {
            $personaje = $p;
            break;
        }
    }

    if (!$personaje) {
        plantilla::aplicar();
        echo "<div class='alert alert-danger'>Personaje no encontrado</div>";
        echo "<a href='index.php' class='btn btn-primary'>Volver</a>";
        exit();
    }

} else {
    plantilla::aplicar();
    echo "<div class='alert alert-danger'>Faltan datos para editar</div>";
    echo "<a href='index.php' class='btn btn-primary'>Volver</a>";
    exit();
}

if ($_POST) {
    foreach ($obra->personajes as &$p) {
        if ($p->cedula == $_POST['cedula']) {
            $p->foto_url = $_POST['foto_url'];
            $p->nombre = $_POST['nombre'];
            $p->apellido = $_POST['apellido'];
            $p->fecha_nacimiento = $_POST['fecha_nacimiento'];
            $p->sexo = $_POST['sexo'];
            $p->habilidades = $_POST['habilidades'];
            $p->comida_favorita = $_POST['comida_favorita'];
            break;
        }
    }

    file_put_contents('datos/' . $obra->codigo . '.json', json_encode($obra));
    plantilla::aplicar();
    echo "<div class='alert alert-success'>Personaje actualizado correctamente</div>";
    echo "<a href='personajes.php?id={$obra->codigo}' class='btn btn-primary'>Volver</a>";
    exit();
}

plantilla::aplicar();
?>

<div class="row">
    <div class="col-md-12">
        <h2><?= $obra->nombre ?></h2>
        <img src ="<?= $obra->foto_url ?>" alt="<?= $obra->nombre ?>" height="200">

        <p><strong>Tipo:</strong> <?= Datos::Tipos_de_Obras()[$obra->tipo] ?></p>
        <p><strong>Autor:</strong> <?= $obra->autor ?></p>
        <p><strong>País:</strong> <?= $obra->pais ?></p>
        <p><strong>Descripción:</strong> <?= $obra->descripcion ?></p>
    </div>

    <div class="col-md-8"> 
        <h2>Editar Personaje</h2>
        <form method="post" action="editar_personaje.php?id=<?= $obra->codigo ?>&cedula=<?= $personaje->cedula ?>" enctype="multipart/form-data">
            <input type="hidden" name="cedula" value="<?= $personaje->cedula ?>">

            <div class="mb-3">
                <label for="foto_url" class="form-label">Foto</label>
                <input type="text" class="form-control" id="foto_url" name="foto_url" value="<?= $personaje->foto_url ?>" required>
            </div>

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $personaje->nombre ?>" required>
            </div>

            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="<?= $personaje->apellido ?>" required>
            </div>

            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= $personaje->fecha_nacimiento ?>" required>
            </div>

            <div class="mb-3">
                <label for="sexo" class="form-label">Sexo</label>
                <select class="form-select" id="sexo" name="sexo">
                    <option value="">Seleccione</option>
                    <option value="masculino" <?= ($personaje->sexo == 'masculino') ? 'selected' : '' ?>>Masculino</option>
                    <option value="femenino" <?= ($personaje->sexo == 'femenino') ? 'selected' : '' ?>>Femenino</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="habilidades" class="form-label">Habilidades</label>
                <input type="text" class="form-control" id="habilidades" name="habilidades" value="<?= $personaje->habilidades ?>">
            </div>

            <div class="mb-3">
                <label for="comida_favorita" class="form-label">Comida Favorita</label>
                <input type="text" class="form-control" id="comida_favorita" name="comida_favorita" value="<?= $personaje->comida_favorita ?>">
            </div>

            <div class="text-center mb-3">
                <button type="submit" class="btn btn-success">Actualizar</button>
                <a href="personajes.php?id=<?= $obra->codigo ?>" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
</div>

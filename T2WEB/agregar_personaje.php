<?php 
include("libreria/principal.php"); 

$obra = new obra();
$personaje = new Personaje();


if (isset($_GET['id'])) {
    $ruta = 'datos/' . $_GET['id'] . '.json';
    if (is_file($ruta)) {
        $json = file_get_contents($ruta);
        $obra = json_decode($json);
    } else {
        plantilla::aplicar();
        echo "<div class='text-center'><div class='alert alert-success'> Guardado correctamente</div>";
        echo "<a href='index.php'class='btn btn-primary'> Volver </a></div>";
        exit();
    }
} else {
    plantilla::aplicar();
    echo "<div class='text-center'><div class='alert alert-danger'> error al cargar la obra</div>";
    echo "<a href='index.php' class='btn btn-primary'> Volver </a></div>";
    exit();
}

plantilla::aplicar();

if($_POST){
    $personaje->cedula = $_POST['cedula'];
    $personaje->foto_url = $_POST['foto_url'];
    $personaje->nombre = $_POST['nombre'];
    $personaje->apellido = $_POST['apellido'];
    $personaje->fecha_nacimiento = $_POST['fecha_nacimiento'];
    $personaje->sexo = $_POST['sexo'];
    $personaje->habilidades = $_POST['habilidades'];
    $personaje->comida_favorita = $_POST['comida_favorita'];
   
    if(!isset($obra->personajes)){
        $obra->personajes = [];
    }

    $obra->personajes[] = $personaje;
    if(!is_dir('datos')){
        echo "<div class='alert alert-danger'>Error al crear la carpeta</div>";
        echo "<a href='index.php' class= 'btn btn-primary'> Volver</a>";
        exit();
    }
    $ruta= 'datos/' .$obra->codigo.'.json';
    file_put_contents($ruta,json_encode($obra));
   
    echo "<div class='alert alert-success'>Personaje guardado</div>";
    echo "<a href='personajes.php?id=.$obra->codigo.''class='btn btn-primary'>Volver</a>";
    exit();
}

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
        <h2>Datos del personaje</h2>
<form method="post" action="agregar_personaje.php?id=<?= $obra->codigo ?>" enctype="multipart/form-data">
    <!-- cedula  -->
    <div class="mb-3">
        <label for="cedula" class="form-label">Cédula</label>
        <input type="text" class="form-control" id="cedula" name="cedula" value="<?= $personaje->cedula ?>" required>
    </div>
    <!-- foto  -->
    <div class="mb-3">
        <label for="foto_url" class="form-label">Foto</label>
        <input type="text" class="form-control" id="foto_url" name="foto_url" accept=".jpg, .jpeg, .png, .gif" required>
    </div>
    <!-- nombre -->
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $personaje->nombre ?>" required>
    </div>
    <!-- apellido -->
    <div class="mb-3">
        <label for="apellido" class="form-label">Apellido</label>
        <input type="text" class="form-control" id="apellido" name="apellido" value="<?= $personaje->apellido ?>" required>
    </div>
    <!-- fecha de nacimiento-->
    <div class="mb-3">
        <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?= $personaje->fecha_nacimiento ?>" required>
    </div>
  <!-- Sexo del personaje -->
<div class="mb-3">
    <label for="sexo" class="form-label">Sexo</label>
    <select class="form-select" id="sexo" name="sexo">
        <option value="">Seleccione</option>
        <option value="masculino" <?= ($personaje->sexo == 'masculino') ? 'selected' : '' ?>>Masculino</option>
        <option value="femenino" <?= ($personaje->sexo == 'femenino') ? 'selected' : '' ?>>Femenino</option>
    </select>
</div>

<!-- Habilidades -->
<div class="mb-3">
    <label for="habilidades" class="form-label">Habilidades</label>
    <input type="text" class="form-control" id="habilidades" name="habilidades" value="<?= $personaje->habilidades ?>">
</div>

<!-- Comida favorita -->
<div class="mb-3">
    <label for="comida_favorita" class="form-label">Comida Favorita</label>
    <input type="text" class="form-control" id="comida_favorita" name="comida_favorita" value="<?= $personaje->comida_favorita ?>">
</div>
<div class="text-center mb-3">
<button type="submit" class="btn btn-primary">Guardar</button>
<a href="personajes.php=<?= $obra->codigo ?>"class="btn btn-danger">Cancelar</a>
</div>
</form>
    </div>
    </div>

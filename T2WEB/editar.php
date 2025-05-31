<?php 
include("libreria/principal.php"); 

$obra = new obra();

if (isset($_GET['id'])) {
    $ruta = 'datos/' . $_GET['id'] . '.json';
    if (is_file($ruta)) {
        $json = file_get_contents($ruta);
        $obra = json_decode($json);
    }
}


if ($_POST) {
    $codigo_original = $_POST['codigo_original'];

    $obra->codigo = $_POST['codigo'];
    $obra->foto_url = $_POST['foto_url'];
    $obra->tipo = $_POST['tipo'];
    $obra->nombre = $_POST['nombre'];
    $obra->descripcion = $_POST['descripcion'];
    $obra->pais = $_POST['pais'];
    $obra->autor = $_POST['autor'];

    if (!is_dir('datos')) {
        mkdir('datos');
    }

    if ($codigo_original != $obra->codigo) {
        $ruta_anterior = 'datos/' . $codigo_original . '.json';
        if (is_file($ruta_anterior)) {
            unlink($ruta_anterior);
        }
    }

    $ruta = 'datos/' . $obra->codigo . '.json';
    $json = json_encode($obra);
    file_put_contents($ruta, $json);

    plantilla::aplicar();
    echo "<div class='alert alert-success'> Obra guardada correctamente </div>";
    echo "<a href='index.php' class='btn btn-primary'> Volver </a>";
    exit();
}

$codigo_original = isset($_GET['id']) ? $_GET['id'] : $obra->codigo;

plantilla::aplicar();
?>

<form method="post" action="editar.php">
    <input type="hidden" name="codigo_original" value="<?= $codigo_original ?>">

  
    <div class="mb-3">
        <label for="codigo" class="form-label">Codigo</label>
        <input type="text" class="form-control" id="codigo" name="codigo" value="<?= $obra->codigo ?>" required>
    </div>
  
    <div class="mb-3">
        <label for="foto_url" class="form-label">Foto</label>
        <input type="text" class="form-control" id="foto_url" name="foto_url" value="<?= $obra->foto_url ?>" required>
    </div>
   
    <div class="mb-3">
        <label for="tipo" class="form-label">Tipo</label>
        <select class="form-select" id="tipo" name="tipo">
            <option value="">Seleccione</option>
            <?php 
            $selected = $obra->tipo;
            foreach (Datos::Tipos_de_Obras() as $key => $value) {
                $isSelected = ($key == $selected) ? 'selected' : '';
                echo "<option value='$key' $isSelected>$value</option>";
            }
            ?>
        </select>
    </div>
    
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $obra->nombre ?>" required>
    </div>
   
    <div class="mb-1">
        <label for="descripcion" class="form-label">Descripcion</label>
        <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= $obra->descripcion ?></textarea>
    </div>
    
    <div class="mb-1">
        <label for="pais" class="form-label">Pais</label>
        <input type="text" class="form-control" id="pais" name="pais" value="<?= $obra->pais ?>" required>
    </div>
   
    <div class="mb-1">
        <label for="autor" class="form-label">Autor</label>
        <input type="text" class="form-control" id="autor" name="autor" value="<?= $obra->autor ?>" required>
    </div>
   
    <div class="text-center mt-3">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </div>
</form>


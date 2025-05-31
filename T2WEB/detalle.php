<?php 
include("libreria/principal.php"); 

plantilla::aplicar();

if (isset($_GET['id'])) {
    $ruta = 'datos/' . $_GET['id'] . '.json';
    if (is_file($ruta)) {
        $json = file_get_contents($ruta);
        $obra = json_decode($json);
    } else {
        echo "<div class='alert alert-danger text-center'>No se encontró la obra.</div>";
        echo "<div class='text-center'><a href='index.php' class='btn btn-primary'>Volver</a></div>";
        exit();
    }
} else {
    echo "<div class='alert alert-danger text-center'>No se especificó una obra.</div>";
    echo "<div class='text-center'><a href='index.php' class='btn btn-primary'>Volver</a></div>";
    exit();
}
?>

<div class="container">
    <h2><?= $obra->nombre ?></h2>
    <div class="row">
        <div class="col-md-6">
            <img src="<?= $obra->foto_url ?>" alt="<?= $obra->nombre ?>" class="img-fluid">
        </div>
        <div class="col-md-6">
            <p><strong>Tipo:</strong> <?= Datos::Tipos_de_Obras()[$obra->tipo] ?></p>
            <p><strong>Autor:</strong> <?= $obra->autor ?></p>
            <p><strong>País:</strong> <?= $obra->pais ?></p>
            <p><strong>Descripción:</strong> <?= $obra->descripcion ?></p>
            <a href="index.php" class="btn btn-secondary">Volver</a>
        </div>
    </div>

    <?php if (isset($obra->personajes) && count($obra->personajes) > 0): ?>
        <hr>
        <h3>Personajes</h3>
        <div class="row">
            <?php foreach ($obra->personajes as $p): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img src="<?= $p->foto_url ?>" class="card-img-top" alt="<?= $p->nombre ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $p->nombre . ' ' . $p->apellido ?></h5>
                            <p class="card-text"><strong>Sexo:</strong> <?= $p->sexo ?></p>
                            <p class="card-text"><strong>Habilidades:</strong> <?= $p->habilidades ?></p>
                            <p class="card-text"><strong>Comida favorita:</strong> <?= $p->comida_favorita ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php 
class plantilla{
    public static $instancia = null;
    public  static function aplicar(): plantilla{
        if (self ::$instancia === null) {
            self::$instancia = new plantilla();
        } return self::$instancia;


    } 
    public function __construct() {
        ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obras a la vista</title>
  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <hr class="container">
    <a href="index.php">
     <h1 class="mt-3"> Obras a la vista</h1> 
     </a>
     <p> Listado de series y peliculas que he visto 😁</p>

   <div style="min-height: 500px;">
        <?php
    }
    public function __destruct() {
            ?>
         </div>
   <hr>
        <div class="text-center">
        Derechos reservados &copy; <?=date(format:'Y')?> -Lo que he visto
        </div>


  </div>
</body>
</html>
        <?php

    }

}
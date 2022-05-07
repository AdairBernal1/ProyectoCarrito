<?php

@include 'config.php';

session_start();

if(!isset($_SESSION['nombre_admin'])){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>pagina admin</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/login.css">

</head>
<body>
   
<div class="container">

   <div class="content">
      <h3>hola <span>admin</span></h3>
      <h1>Bienvenido!! <span><?php echo $_SESSION['nombre_admin'] ?></span></h1>
      <p>Esta es la pagina de administrador</p>
      <a href="login.php" class="btn">Iniciar sesion</a>
      <a href="registrar.php" class="btn">Registrarme</a>
      <a href="logout.php" class="btn">Cerrar sesion</a>
   </div>

</div>

</body>
</html>
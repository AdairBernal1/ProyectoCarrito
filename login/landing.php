<?php
session_start();
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

      <?php
         if(isset($_SESSION['nombre_admin'])){
            echo ('<p>Esta es la pagina de administrador</p>');
         }
         else{
            echo ('<p>Esta es la pagina de usuario</p>');
         }
      ?>
      <?php if(isset($_SESSION['nombre_admin'])) : ?>
         <a href="../menu/adminpanel.php" class="btn">Agregar Productos</a>
      <?php endif ?>

      <a href="../menu/products.php" class="btn">Comprar</a>
      <a href="logout.php" class="btn">Cerrar sesion</a>
   </div>

</div>

</body>
</html>
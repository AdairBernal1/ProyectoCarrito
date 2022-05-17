<?php
session_start();
if(!isset($_SESSION['nombre_admin']) && (!isset($_SESSION['nombre_usuario']))){
    header("Location:https://adairbernal.000webhostapp.com/practica_carrito/login/login.php");
};
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
      <?php if(isset($_SESSION['nombre_admin'])) : ?>
        <h3>Hola <span>Admin</span></h3>
        <h1>Bienvenido!! <span><?php echo $_SESSION['nombre_admin'] ?></span></h1>
        <p>Esta es la pagina de administrador</p>
        <a href="../menu/adminpanel.php" class="btn">Agregar Productos</a>
      <?php endif ?>
      
      <?php if(isset($_SESSION['nombre_usuario'])) : ?>
        <h3>Hola</h3>
        <h1>Bienvenido!! <span><?php echo $_SESSION['nombre_usuario'] ?></span></h1>
        <p>Esta es la pagina de usuario</p>
      <?php endif ?>

      <a href="../menu/products.php" class="btn">Comprar</a>
      <a href="logout.php" class="btn">Cerrar sesion</a>
   </div>

</div>

</body>
</html>
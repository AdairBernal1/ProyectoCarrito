<?php

@include '../config.php';

$usuario = "";
$email = "";

if(isset($_SESSION['nombre_admin'])){
    $usuario = $_SESSION['nombre_admin'];
    $sqlres = mysqli_query($conn, "SELECT email from users where name = '$usuario'");
    $emailRow = mysqli_fetch_array($sqlres);
    $email = $emailRow["email"];
}else{
    $usuario = $_SESSION['nombre_usuario'];
    $sqlres = mysqli_query($conn, "SELECT email from users where name = '$usuario'");
    $emailRow = mysqli_fetch_array($sqlres);
    $email = $emailRow["email"];

}

?>
<header class="header">

   <div class="flex">

      <a href="#" class="logo">FoodToGo</a>

      <nav class="navbar">
         <?php if(isset($_SESSION['nombre_admin'])) : ?>
            <a href="../menu/adminpanel.php">AdminPanel</a>
         <?php endif ?>
         <a href="products.php">Ver Productos</a>
         <a href="../login/logout.php">Cerrar sesion</a>
      </nav>

      <?php
      
      $select_rows = mysqli_query($conn, "SELECT * FROM `cart` where user = '$email'") or die('query failed');
      $row_count = mysqli_num_rows($select_rows);

      ?>

      <a href="cart.php" class="cart">Carrito <span><?php echo $row_count; ?></span> </a>

      <div id="menu-btn" class="fas fa-bars"></div>

   </div>

</header>
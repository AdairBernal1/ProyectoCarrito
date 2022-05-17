<?php
session_start();
if(!isset($_SESSION['nombre_admin']) && (!isset($_SESSION['nombre_usuario']))){
    header("Location:https://adairbernal.000webhostapp.com/practica_carrito/login/login.php");
};

@include '../config.php';

if(isset($_POST['update_update_btn'])){
   $update_value = $_POST['update_quantity'];
   $update_id = $_POST['update_quantity_id'];
   $update_quantity_query = mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id'");
    header('location:cart.php');
};

if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'");
   header('location:cart.php');
};

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart`");
   header('location:cart.php');
}

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

@include 'header.php'; 
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/estilo.css">

</head>
<body>

<div class="container">

<section class="shopping-cart">

   <h1 class="heading">Carrito</h1>

   <table>

      <thead>
         <th>Imagen</th>
         <th>Nombre</th>
         <th>Precio</th>
         <th>Cantidad</th>
         <th>Total</th>
         <th>Accion</th>
      </thead>

      <tbody>

         <?php 
         
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart` where user = '$email'");
         $grand_total = number_format(0);
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
         ?>

         <tr>
            <td><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
            <td><?php echo $fetch_cart['name']; ?></td>
            <td>$<?php echo number_format($fetch_cart['price']); ?>MXN</td>
            <td>
               <form action="" method="post">
                  <input type="hidden" name="update_quantity_id"  value="<?php echo $fetch_cart['id']; ?>" >
                  <input type="number" name="update_quantity" min="1"  value="<?php echo $fetch_cart['quantity']; ?>" >
                  <input type="submit" value="update" name="update_update_btn">
               </form>   
            </td>
            <td>$<?php echo number_format($sub_total = $fetch_cart['price'] * $fetch_cart['quantity']); ?>MXN</td>
            <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('¿Quitar articulo del carrito?')" class="delete-btn"> <i class="fas fa-trash"></i> Eliminar</a></td>
         </tr>
         <?php
           $grand_total += $sub_total;  
            };
         };
         ?>
         <tr class="table-bottom">
            <td><a href="products.php" class="option-btn" style="margin-top: 0;">Seguir comprando</a></td>
            <td colspan="3">Total</td>
            <td>$<?php echo number_format($grand_total); ?>MXN</td>
            <td><a href="cart.php?delete_all" onclick="return confirm('¿Estas seguro de eliminar tu carrito?');" class="delete-btn"> <i class="fas fa-trash"></i> Eliminar carrito </a></td>
         </tr>

      </tbody>

   </table>

   <div class="checkout-btn">
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">Checkout</a>
   </div>

</section>

</div>
   
<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
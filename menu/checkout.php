<?php
session_start();
if(!isset($_SESSION['nombre_admin']) && (!isset($_SESSION['nombre_usuario']))){
    header("Location:https://adairbernal.000webhostapp.com/practica_carrito/login/login.php");
};

@include '../config.php';

if(isset($_POST['order_btn'])){

   $name = $_POST['name'];
   $number = $_POST['number'];
   $method = $_POST['method'];
   $calle = $_POST['calle'];
   $colonia = $_POST['colonia'];

   $cart_query = mysqli_query($conn, "SELECT * FROM `cart`");
   $price_total = 0;
   if(mysqli_num_rows($cart_query) > 0){
      while($product_item = mysqli_fetch_assoc($cart_query)){
         $product_name[] = $product_item['name'] .' ('. $product_item['quantity'] .') ';
         $product_price = number_format($product_item['price'] * $product_item['quantity']);
         $price_total += $product_price;
      };
   };

   $total_product = implode(', ',$product_name);
   $detail_query = mysqli_query($conn, "INSERT INTO `order`(name, number, method, calle, colonia, total_products, total_price) VALUES('$name','$number','$method','$calle','$colonia','$total_product','$price_total')") or die('query failed');

   if($cart_query && $detail_query){
      echo "
      <div class='order-message-container'>
      <div class='message-container'>
         <h3>¡Gracias por tu compra!</h3>
         <div class='order-detail'>
            <span>".$total_product."</span>
            <span class='total'> total : $".$price_total."MXN  </span>
         </div>
         <div class='customer-details'>
            <p> Tu nombre : <span>".$name."</span> </p>
            <p> Tu numero : <span>".$number."</span> </p>
            <p> Tu forma de pago : <span>".$method."</span> </p>
            <p>(*pago efectivo*)</p>
         </div>
            <a href='products.php' class='btn'>Seguir comprando</a>
         </div>
      </div>
      ";
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/estilo.css">

</head>
<body>

<?php include 'header.php'; ?>

<div class="container">

<section class="checkout-form">

   <h1 class="heading">Completa tu orden</h1>

   <form action="" method="post">

   <div class="display-order">
      <?php
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
         $total = 0;
         $grand_total = 0;
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = number_format($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total = $total += $total_price;
      ?>
      <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
      <?php
         }
      }else{
         echo "<div class='display-order'><span>¡Tu carro esta vacio!</span></div>";
      }
      ?>
      <span class="grand-total"> total : $<?= $grand_total; ?>MXN </span>
   </div>

      <div class="flex">
         <div class="inputBox">
            <span>Nombre de recipiente</span>
            <input type="text" placeholder="Ingresa tu nombre" name="name" required>
         </div>
         <div class="inputBox">
            <span>Numero de telefono</span>
            <input type="number" placeholder="Ingresa tu numero de telefono" name="number" required>
         </div>
         <div class="inputBox">
            <span>Forma de pago</span>
            <select name="method">
               <option value="pago en efectivo" selected>Pago en efectivo</option>
               <option value="tarjeta">Tarjeta</option>
               <option value="paypal">Paypal</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Direccion 1</span>
            <input type="text" placeholder="ej. Calle Marina Nacional #1515" name="calle" required>
         </div>
         <div class="inputBox">
            <span>Direccion 2 (Opcional)</span>
            <input type="text" placeholder="ej. Colonia 72" name="colonia" >
         </div>
      </div>
      <input type="submit" value="Ordenar" name="order_btn" class="btn">
   </form>

</section>

</div>

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>
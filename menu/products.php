<?php
session_start();
if(!isset($_SESSION['nombre_admin']) && (!isset($_SESSION['nombre_usuario']))){
    header("Location:https://adairbernal.000webhostapp.com/practica_carrito/login/login.php");
};
?>

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

<?php

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = 1;

   $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE name = '$product_name' and user = '$email'");

   if(mysqli_num_rows($select_cart) > 0){
      $message[] = "$product_name ya se encuentra en carrito!";
   }else{
      $insert_product = mysqli_query($conn, "INSERT INTO cart (name, price, image, quantity, user) VALUES('$product_name', '$product_price', '$product_image', '$product_quantity', '$email')");
      $message[] = "$product_name agregado al carrito de $usuario";
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
   
<?php

if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};

@include 'header.php';
?>

<div class="container">

<section class="products">

   <h1 class="heading">Productos</h1>

   <div class="box-container">
       <h1><a href="products.php">Lo nuevo</a></h1>
       <h1><a href="products.php">Lo mas vendido</a></h1>
       <h1><a href="products.php">Favoritos</a></h1>

      <?php

        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 6;
        $offset = ($pageno-1) * $no_of_records_per_page;

        $total_pages_sql = "SELECT COUNT(*) FROM products";
        $result = mysqli_query($conn,$total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $sql = "SELECT * FROM products LIMIT $offset, $no_of_records_per_page";
        $res_data = mysqli_query($conn,$sql);
        while($fetch_product = mysqli_fetch_assoc($res_data)){
      ?>

      <form action="" method="post">
         <div class="box">
            <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="">
            <h3><?php echo $fetch_product['name']; ?></h3>
            <div class="price">$<?php echo $fetch_product['price']; ?>MXN</div>
            <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
            <input type="submit" class="btn" value="Agregar al carrito" name="add_to_cart">
         </div>
      </form>

      <?php
         };
      ?>
      

   </div>
   
    <ul class="pagination">
        <li><a href="?pageno=1">Primera</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Anterior</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Siguiente</a>
        </li>
        <li><a href="?pageno=<?php echo $total_pages; ?>">Ultima</a></li>
    </ul>

</section>

</div>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
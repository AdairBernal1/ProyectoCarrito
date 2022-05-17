<?php

@include '../config.php';

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = md5($_POST['password']);

   $select = " SELECT * FROM users WHERE email = '$email' && password = '$pass' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){
       
      session_start();
      $row = mysqli_fetch_array($result);

      if($row['user_type'] == 'admin'){
         $_SESSION['nombre_admin'] = $row['name'];
         header("Location:https://adairbernal.000webhostapp.com/practica_carrito/menu/products.php");
      }elseif($row['user_type'] == 'usuario'){
         $_SESSION['nombre_usuario'] = $row['name'];
         header("Location:https://adairbernal.000webhostapp.com/practica_carrito/menu/products.php");
      };
     
   }else{
      $error[] = 'Correo o contraseña incorrectos :(';
   };

};
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Inicio de sesion</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/login.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Ingresa ahora!</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="email" name="email" required placeholder="correo electronico">
      <input type="password" name="password" required placeholder="contraseña">
      <input type="submit" name="submit" value="Iniciar sesion" class="form-btn">
      <p>No tienes una cuenta? <a href="registrar.php">Registrate ahora!</a></p>
   </form>

</div>

</body>
</html>
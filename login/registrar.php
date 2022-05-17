<?php

@include '../config.php';

$name = "";
$email = "";

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $password = $_POST['password'];
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   $select = " SELECT * FROM users WHERE email = '$email' ";

   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){

      $error[] = 'El nombre de usuario ya existe';

   }else{
       if (strlen($password) < 8 || strlen($password) > 16) {
          $error[] = "Contraseña deber tener entre 8 caracteres y 16 caracteres";
       }
       else if (!preg_match("/\d/", $password)) {
          $error[] = "Contraseña debe contener al menos un digito";
       }
       else if (!preg_match("/[A-Z]/", $password)) {
          $error[] = "Contraseña deberia contener al menos una mayuscula";
       }
       else if (!preg_match("/[a-z]/", $password)) {
          $error[] = "Contraseña deberia incluir al menos una minuscula";
       }
       else if (!preg_match("/\W/", $password)) {
          $error[] = "Contraseña deberia incluir al menos un caracter especial";
       }
       else if (preg_match("/\s/", $password)) {
          $error[] = "Contraseña no deberia contener espacios en blanco";
       }
       else {
          if($pass != $cpass){
            $error[] = 'Las contraseñas no coinciden!';
          }else{
            $insert = "INSERT INTO users(name, email, password, user_type) VALUES('$name','$email','$pass','$user_type')";
            mysqli_query($conn, $insert);
            header('location:login.php');
          }
            
        }
   }

};


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>registrar</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/login.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Registrate</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="text" name="name" required placeholder="Nombre" value = <?php echo $name ?>>
      <input type="email" name="email" required placeholder="Correo electronico" value = <?php echo $email ?>>
      <input type="password" name="password" required placeholder="Contraseña">
      <input type="password" name="cpassword" required placeholder="Confirmar contarseña">
      <select name="user_type">
         <option value="usuario">Usuario</option>
         <option value="admin">Admin</option>
      </select>
      <input type="submit" name="submit" value="Registrarme" class="form-btn">
      <p>¿Ya tienes una cuenta? <a href="login.php">Ingresa</a></p>
   </form>

</div>

</body>
</html>
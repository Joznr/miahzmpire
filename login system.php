<?php

include 'config.php';

if(insset($_POST['submit'])){

  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
  $cpass = mysqli_real_escape_string($conn, md5($_POST['name']));
  $image = $_FILES['image']['name'];
  $image_size = $_FILES['image']['size'];
  $image_tmp_name = $_FILES['image']['tmp-name'];
  $image_folder = 'uploaded_img/'.$image;

  $select = mysqli_query($conn, "SELECT * FROM  `user_registeration`WHERE name = '$name'AND password = '$pass'") or die('query failed');

  if(mysqli_num_rows($select) > 0){
    $message[] = 'user already exist'
  }else{
    if($pass != $cpass){
      $message[] = 'confirm password not matched!';
    }elseif($image_size > 2000000){
      $message = 'image size is too large!';
    }else{
      $insert = mysqli_query($conn, "INSERT INTO `user_registeration`(name, password, image) VALUES('$name', '$pass', '$image')") or die('query failed');

      if($insert){
        move_uploaded_file($image_tmp_name, $image_folder);
        $message[] = 'registered successfully!';
      }
    }
  }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
</head>
<body>
  <div class="wrapper">
    <div class="form-box">
      <form action="" method="post" enctype="multipart/from-data">
        <h3>Register</h3>
        <?php
        if(isset($message)){
          foreach($message as $message){
            echo '<div class"message">'.$message.'</div>';
          }
        }
        <img src="" alt="">
        <input type="text" name="name" placeholder="username" class="box">

        <img src="" alt="">
        <input type="password" name="pass" placeholder="password" class="box">

        <img src="" alt="">
        <input type="passwrod" name="cpass" placeholder="confirm passwrod" class="box">

        <img src="" alt="">
        <input type="file" name="image" class="box" accept="image/jpg, image/jpeg,image/png">

        <img src="" alt="">
        <button type="submit">Submit</button>
      </form>
    </div>
  </div>
</body>
</html>
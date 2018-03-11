<?php
session_start();
require("ConnectMySQL.php");

  if( $_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['btn-register']))
  {
    $_POST['r_pseudo'] = filter_var($_POST["r_pseudo"], FILTER_SANITIZE_STRING);
    $_POST['r_email'] = filter_var($_POST["r_email"], FILTER_SANITIZE_EMAIL);
    $_POST['r_password'] = filter_var($_POST["r_password"], FILTER_SANITIZE_STRING);
    $_POST['r_confirmpassword'] = filter_var($_POST["r_confirmpassword"], FILTER_SANITIZE_STRING);
    $_POST['btn-register'] = filter_var($_POST["btn-register"], FILTER_SANITIZE_STRING);

    $valid = true;
    if(empty($_POST['r_pseudo']))$valid = false;
    if(empty($_POST['r_email']))$valid = false;
    if(empty($_POST['r_password']))$valid = false;
    if(empty($_POST['r_confirmpassword']))$valid = false;
    if(empty($_POST['btn-register']))$valid = false;

    if($_POST['r_password'] != $_POST['r_confirmpassword'])$valid = false;

    if($valid)
    {
      $bdd = ConnectMySQL();

      $req = $bdd->prepare('SELECT count(*)
                            FROM users
                            WHERE pseudo = :pseudo
                            || email = :email
                          ');
      $req->execute(array(
              'pseudo'  => $_POST['r_pseudo'],
              'email'   => $_POST['r_email']
            ));

      $number = $req->fetchColumn();

      if($number == 0)
      {
        $req = $bdd->prepare('INSERT INTO users(pseudo, email, password) VALUES(:pseudo, :email, :password)');
        $succeed = $req->execute(array(
            'pseudo'    => $_POST['r_pseudo'],
            'email'     => $_POST['r_email'],
            'password'  => sha1($_POST['r_password'])
            ));
        if($succeed)
        {
          //connexion!!!!!
          header('location:index.php');
        }
      }
    }

    /*Chargement de l'image*/
    /*Transforme l'image en base64*/
    if(isset($_FILES['file_image']) && $_FILES['file_image']['error'] == 0)
    {

      if($_FILES['file_image']['size'] < 100000)
      {
        $path = $_FILES['file_image']['tmp_name'];
        $type = $_FILES['file_image']['type'];
        $size = 50;
        $compression = 75;

        if($type == 'image/png')
        {
          $image = imagecreatefrompng($path);
          $image_scale = imagescale($image, $size, $compression);
          imagepng($image_scale,$path);
          $data = file_get_contents($path);
          $base64 = 'data:image/png;base64,';
          $base64 .= base64_encode($data);
          echo '<image src="' .$base64. '" >';
        }
        elseif($type == 'image/jpeg')
        {
          $image = imagecreatefromjpeg($path);
          $image_scale = imagescale($image, $size, $compression);
          imagejpeg($image_scale,$path);
          $data = file_get_contents($path);
          $base64 = 'data:image/jpeg;base64,';
          $base64 .= base64_encode($data);
          echo '<image src="' .$base64. '" >';
        }
        elseif($type == 'image/gif')
        {
          $black = imagecolorallocate($im, 0, 0, 0);
          $image = imagecreatefromgif($path);
          imagecolortransparent($image, $black);
          $image_scale = imagescale($image, $size, $compression);
          imagegif($image_scale,$path);
          $data = file_get_contents($path);
          $base64 = 'data:image/gif;base64,';
          $base64 .= base64_encode($data);
          echo '<image src="' .$base64. '" >';
        }
      }

      //ok
      // $data = file_get_contents($path);
      // $hex_string = 'data:image/png;base64,' .base64_encode($data);
      // echo '<image src="' .$hex_string. '" >';
      //ok
      // $src_image = imagescale(imagecreatefrompng($path), 50);
      // imagepng($src_image,$path);
      // $data = file_get_contents($path);
      // $hex_string = 'data:image/png;base64,' .base64_encode($data);
      // echo '<image src="' .$hex_string. '" >';
      //ok
      // echo "<br/>";
      // $image = imagecreatefrompng($path);
      // $image_scale = imagescale($image, $size, $compression);
      // imagepng($image_scale,$path);
      // $data = file_get_contents($path);
      // $base64 = 'data:image/png;base64,';
      // $base64 .= base64_encode($data);
      // echo '<image src="' .$base64. '" >';



      // echo "<br/>";
      // $src_image = imagecreatefrompng($_FILES['file_image']["tmp_name"]);
      // $ok = imagescale($src_image, 25);
      // $hex_string = 'data:image/png;base64,' .base64_encode($ok);
      // echo '<image src="' .$hex_string. '" >';

      // var_dump($hex_string);
      // echo $hex_string;
      // header( "Content-type: image/png" );
      // header( "Content-type: image/jpeg" );
      // var_dump( $_FILES['file_image']["tmp_name"]);
//       $size = 25;
//       $new_image = imagecreatetruecolor($size, $size);
//       // $sizeimage = getimagesize($new_image);
//       // var_dump($sizeimage);
// echo "<br/>";
// var_dump($new_image);
// echo "<br/>";
// // $src_image = imagecreatefromjpeg($_FILES['file_image']["tmp_name"]);
//       $src_image = imagecreatefrompng($_FILES['file_image']["tmp_name"]);
//       var_dump($src_image);
//       echo "<br/>";
//
//       // $ok = imagecopyresampled($new_image, $src_image, 0, 0, 0, 0, $size, $size, imagesx($src_image), imagesy($src_image));
//       $ok = imagescale($src_image, 25);
//
//       var_dump($ok);
//       echo "<br/>";
// var_dump(imagesx($ok));
// $photo = base64_encode($ok);
// $photo = base64_decode($_FILES['file_image']["tmp_name"]);
// echo "<br/>";
// var_dump($photo);
// file_put_contents('./avatar/photo_1.png', $photo);
// echo '<img src="/avatar/photo_1.png"/>';
// echo "2";
//       $filename = "avatar/morgan.jpeg";
//       $compression = 75;
//       $test= imagepng($src_image,'morgan.png');
      // $test= imagepng($new_image,'morgan.png');
      // $test= imagepng($ok,'morgan.png');
      // $test= imagepng($_FILES['file_image']["tmp_name"],'morgan.png');
      // imagejpeg($_FILES['file_image']["tmp_name"],'morgan.jpg');
      // imagejpeg($ok,'morgan.jpg');
      // imagejpeg($ok,$filename,$compression);
      // echo "3";
// echo "<br/>";
//       var_dump($test);
      // readfile($_FILES['file_image']["tmp_name"]);
      // move_uploaded_file($_FILES['file_image']['tmp_name'], $filename);
    }
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="css/register.css">
  </head>
  <body>
    <section>
      <header>
              <li><a href="index.php">Home</a></li>
      </header>
      <main class="main--register">
        <fieldset>
          <legend>formulaire d'inscription</legend>
          <form enctype="multipart/form-data" class="" action="register.php" method="post">
            <label for="pseudo"><input type="text" name="r_pseudo" value="a" placeholder="votre pseudo" required></label>
            <label for="email"><input type="email" name="r_email" value="a@gmail.com" placeholder="votre email" required></label>
            <label for="password"><input type="password" name="r_password" value="a" required></label>
            <label for="confirmpassword"><input type="password" name="r_confirmpassword" value="a" required></label>
            <label for=""> <input type="file" name="file_image" value=""> </label>
            <input type="submit" name="btn-register" value="inscription">
          </form>
        </fieldset>
      </main>
      <footer></footer>
    </section>
  </body>
</html>

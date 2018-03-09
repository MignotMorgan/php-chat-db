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

    //Sanitization
    //password == confirmpassword
    //pseudo existe déjà?
    //valeur empty?
    //mot de pass valide?
    //email valide?
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
  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Inscription</title>
    <link rel="stylesheet" href="style-register.css">
  </head>
  <body>
    <section>
      <header>
              <li><a href="index.php">Home</a></li>
      </header>
      <main class="main--register">
        <fieldset>
          <legend>formulaire d'inscription</legend>
          <form class="" action="register.php" method="post">
            <label for="pseudo"><input type="text" name="r_pseudo" value="" placeholder="votre pseudo" required></label>
            <label for="email"><input type="email" name="r_email" value="" placeholder="votre email" required></label>
            <label for="password"><input type="password" name="r_password" value="" required></label>
            <label for="confirmpassword"><input type="password" name="r_confirmpassword" value="" required></label>
            <input type="submit" name="btn-register" value="inscription">
          </form>
        </fieldset>
      </main>
      <footer></footer>
    </section>
  </body>
</html>

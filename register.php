<?php
require("ConnectMySQL.php");
// require("MySanitization.php");
//
// Post_Sanitization();

  if( $_SERVER['REQUEST_METHOD']=='POST')
  {
    $_POST['pseudo'] = filter_var($_POST["pseudo"], FILTER_SANITIZE_STRING);
    $_POST['email'] = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $_POST['password'] = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
    $_POST['confirmpassword'] = filter_var($_POST["confirmpassword"], FILTER_SANITIZE_STRING);
    $_POST['btn-register'] = filter_var($_POST["btn-register"], FILTER_SANITIZE_STRING);

    $valid = true;
    if(empty($_POST['pseudo']))$valid = false;
    if(empty($_POST['email']))$valid = false;
    if(empty($_POST['password']))$valid = false;
    if(empty($_POST['confirmpassword']))$valid = false;
    if(empty($_POST['btn-register']))$valid = false;

    if($_POST['password'] != $_POST['confirmpassword'])$valid = false;

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
              'pseudo'  => $_POST['pseudo'],
              'email'   => $_POST['email']
            ));

      $number = $req->fetchColumn();

      if($number == 0)
      {
        $req = $bdd->prepare('INSERT INTO users(pseudo, email, password) VALUES(:pseudo, :email, :password)');
        $succeed = $req->execute(array(
            'pseudo'    => $_POST['pseudo'],
            'email'     => $_POST['email'],
            'password'  => sha1($_POST['password'])
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
  </head>
  <body>
    <section>
      <header>

      </header>
      <main>
        <form class="" action="register.php" method="post">
          <label for="pseudo"><input type="text" name="pseudo" value="" placeholder="pseudo"></label>
          <label for="email"><input type="text" name="email" value="" placeholder="email"></label>
          <label for="password"><input type="text" name="password" value=""></label>
          <label for="confirmpassword"><input type="text" name="confirmpassword" value=""></label>
          <input type="submit" name="btn-register" value="inscription">
        </form>
      </main>
      <footer></footer>
    </section>
  </body>
</html>

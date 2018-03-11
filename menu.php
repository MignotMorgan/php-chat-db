<link rel="stylesheet" href="css/menu.css">
<?php
  if( $_SERVER['REQUEST_METHOD']=='POST')
  {
    if(isset($_POST['btn_login']))
    {
      $_POST['pseudo'] = filter_var($_POST["pseudo"], FILTER_SANITIZE_STRING | FILTER_SANITIZE_EMAIL);
      $_POST['password'] = filter_var($_POST["password"], FILTER_SANITIZE_STRING);

      $valid = true;
      if(empty($_POST['pseudo']))$valid = false;
      if(empty($_POST['password']))$valid = false;

      if($valid)
      {
        $bdd = ConnectMySQL();

        $req = $bdd->prepare('SELECT id, pseudo, email
                              FROM users
                              WHERE pseudo = :pseudo
                              && password = :password
                              || email = :pseudo
                              && password = :password
                            ');
        $req->execute(array(
                'pseudo'  => $_POST['pseudo'],
                'password'   => $_POST['password']
              ));

       $tab = $req->fetchAll(PDO::FETCH_ASSOC);

       if(sizeof($tab) == 1)
       {
         $_SESSION['user'] = $tab[0];
       }

      }
    }
    if(isset($_POST['btn_disconnect']))
    {
      session_destroy();
      header('location:index.php');

    }
  }
 ?>
<form class="form--menu" action="index.php" method="post">

  <nav class="nav--menu">
    <ul>
      <li>
        <?php if( !isset($_SESSION['user']) || empty($_SESSION['user'])): ?>
        <section class="section--login">
          <input type="text" name="pseudo" value="" placeholder="pseudo ou email">
          <input type="password" name="password" value="">
          <input type="submit" name="btn_login" value="connection">
          <a class="a--register" href="register.php">inscrivez-vous</a>
        </section>
      <?php endif; ?>
      <?php if( isset($_SESSION['user']) && !empty($_SESSION['user'])): ?>
        <section class="section--login">
          <label for=""><?php echo $_SESSION['user']['pseudo'] ?></label>
          <label for=""><?php echo $_SESSION['user']['email'] ?></label>
          <input type="submit" name="btn_disconnect" value="déconnection">
        </section>
      <?php endif; ?>
      </li>
    </ul>

  </nav>

</form>

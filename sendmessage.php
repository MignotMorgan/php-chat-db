<?php
session_start();
require("ConnectMySQL.php");


// print_r($_SESSION['user']);

if( $_SERVER['REQUEST_METHOD']=='POST')
{
  if(isset($_POST['btn_send']))
  {
    $_POST['send_message'] = filter_var($_POST["send_message"], FILTER_SANITIZE_STRING);
    $users_id = (int)$_SESSION['user']['id'];
    if( is_int($users_id) && !empty($_POST['send_message']))
    {
      $bdd = ConnectMySQL();
      $req = $bdd->prepare('INSERT INTO messages(users_id, message)
                            VALUES(:users_id, :message)
                          ');
      $succeed = $req->execute(array(
          'users_id'  => $users_id,
          'message'   => $_POST['send_message']
      ));
      if($succeed)
      {
        // header('location:index.php');
      }
    }

  }
}




 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Envoi de messages</title>
     <link rel="stylesheet" href="style-sendmessage.css">
   </head>
   <body>
     <section>
         <?php if(!empty($_SESSION['user'])):?>
         <form class="" action="sendmessage.php" method="post">
           <input class="section--message-input" type="text" name="send_message" value="" placeholder="écrire un message" >
           <input type="submit" name="btn_send" value="envoyer" >
         </form>
       <?php else: ?>
         <input type="text" name="send_message" value="" placeholder="connectez-vous." disabled>
         <input type="submit" name="btn_send" value="envoyer" disabled>
      <?php endif; ?>
     </section>
   </body>
 </html>

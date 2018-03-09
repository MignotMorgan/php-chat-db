<?php
session_start();
require("ConnectMySQL.php");

$bdd = ConnectMySQL();

$req = $bdd->prepare('SELECT users.pseudo, messages.datetime, messages.message
                      FROM messages
                      LEFT JOIN users
                      ON messages.users_id = users.id
                    ');

$req->execute();

$tab = $req->fetchAll(PDO::FETCH_ASSOC);
 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="5">
    <title>Conversation</title>
    <link rel="stylesheet" href="style-conversation.css">
  </head>
  <body>
    <?php for($i=sizeof($tab)-1; $i >= 0 ; $i--): ?>
      <?php
          //if($i%2==0 )
          if($tab[$i]['pseudo'] != $_SESSION['user']['pseudo'])
          {
            $divClass = 'div--messages-left';
            $pseudoClass = 'pseudo-left';
            $datetimeClass = 'datetime-left';
            $txtClass = 'txt--left';
          }
          else
          {
            $divClass = 'div--messages-right';
            $pseudoClass = 'pseudo-right';
            $datetimeClass = 'datetime-right';
            $txtClass = 'txt--right';
          }
       ?>
      <div class="div--messages <?php echo $divClass ?>">
        <label class="lbl--messages-pseudo <?php echo $pseudoClass; ?>" for=""><?php print_r($tab[$i]['pseudo']) ?></label>
        <label class="lbl--messages-datetime <?php echo $datetimeClass; ?>" for=""><?php print_r($tab[$i]['datetime']) ?></label>
        <label class="lbl--messages-message <?php echo $txtClass; ?>" for=""><?php print_r($tab[$i]['message']) ?></label>
      </div>
    <?php endfor; ?>
  </body>
</html>

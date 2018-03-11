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
            $divClass = 'div--left';
            $avatarClass = 'div--avatar-left';
            $triClass = 'tri-left';
            $pseudoClass = 'lbl--pseudo-left';
            $datetimeClass = 'lbl--datetime-left';
            $bubbleClass = 'div--bubble-left';
            $txtClass = 'lbl--txt-left';
          }
          else
          {
            $divClass = 'div--right';
            $avatarClass = 'div--avatar-right';
            $triClass = 'tri-right';
            $pseudoClass = 'lbl--pseudo-right';
            $datetimeClass = 'lbl--datetime-right';
            $bubbleClass = 'div--bubble-right';
            $txtClass = 'lbl--txt-right';
          }
       ?>

      <div class="div--messages  <?php echo $divClass ?>">
        <div class=" div--avatar <?php echo $avatarClass; ?>"></div>
        <div class="tri <?php echo $triClass; ?>"></div>
        <div class="div--bubble <?php echo $bubbleClass ?>">
          <label class="lbl--pseudo <?php echo $pseudoClass; ?>" for=""><?php print_r($tab[$i]['pseudo']) ?></label>
          <label class="lbl--datetime <?php echo $datetimeClass; ?>" for=""><?php print_r($tab[$i]['datetime']) ?></label>
          <label class="lbl--txt <?php echo $txtClass; ?>" for=""><?php print_r($tab[$i]['message']) ?></label>
        </div>
    </div>
    <?php endfor; ?>
  </body>
</html>

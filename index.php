<?php
  session_start();
  require("ConnectMySQL.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Chat</title>
    <link rel="stylesheet" href="css/index.css">
  </head>
  <body>
    <section class=" box--message">
      <header>
        <h1>Ze chat</h1>
        <?php require("menu.php"); ?>
      </header>
      <main>
        <section class="section--messages">
          <iframe  src="conversation.php" width="100%" height="100%" scrolling="true" seamless></iframe>
        </section>
        <section class="section--send">
          <iframe src="sendmessage.php" width="100%" height="100%" scrolling="no"></iframe>
        </section>
      </main>
      <footer>

      </footer>
    </section>
  </body>
</html>

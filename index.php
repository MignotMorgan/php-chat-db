<?php
  session_start();
  require("ConnectMySQL.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Chat</title>
    <link rel="stylesheet" href="style-index.css">
  </head>
  <body>
    <section class=" box--message">
      <header>
        <h1>Ze chat</h1>
        <?php require("menu.php"); ?>
      </header>
      <main>
        <section class="section--messages">
          <header>

          </header>
          <main>
            <div class="section--message-iframe">
              <iframe  src="conversation.php" width="100%" height="100%" scrolling="true" frameborder="0" seamless></iframe>
            </div>
          </main>
        </section>
        <section class="section--send-message">
          <iframe src="sendmessage.php" width="100%" height="100%" frameborder="0"></iframe>
        </section>
      </main>
      <footer>

      </footer>
    </section>
  </body>
</html>

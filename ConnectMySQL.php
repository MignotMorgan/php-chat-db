<?php
function ConnectMySQL()
{
  try
  {
    $bdd = new PDO('mysql:host=localhost;dbname=php-chat-db;charset=utf8', 'root', 'user');
    // $bdd = new PDO('mysql:host=localhost;dbname=id4734921_todolist;charset=utf8', 'id4734921_root', 'webhost1974');
  }
  catch (Exception $e)
  {
    die('Erreur : ' . $e->getMessage());
  }
  return $bdd;
};
 ?>

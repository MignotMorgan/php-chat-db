<?php
function Post_Sanitization()
{
  for($i=0; $i < sizeof($_POST); $i++)
    $_POST[$i] = MySanitization($_POST[$i]);
}

function MySanitization($nosanitized)
{
  $sanitized = filter_var($nosanitized, FILTER_SANITIZE_STRING);
  $sanitized = htmlentities($sanitized);
  return $sanitized;
}
 ?>

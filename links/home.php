<?php
  include '../conn.php';
  error_reporting(0);
  session_start();

  $user_id = $_SESSION['user_id'];
  echo $user_id;

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;400&display=swap" rel="stylesheet">
  <title>Home</title>
</head>
<body>

</body>
</html>

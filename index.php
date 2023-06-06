<?php
  include 'conn.php';
  error_reporting(0);
  session_start();
  $user_id = "";
  $user_id = $_SESSION['user_id'];
  // echo $user_id;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <title>Home</title>
</head>
<body>
  <header>
	<nav>
		<ul class="navbar__links">
			<li><a href="index.php">Acasă</a></li>
      <?php
       if($user_id == null){
          echo '<li><a href="links/login.php">Rezervări</a></li>
                <li><a href="links/login.php">Profil</a></li>
                <li><a href="links/login.php">Conectare</a></li>';
        }
        else {
          if($user_id == 1) {
            echo '<li><a href="links/books.php">Cărți</a></li>
                  <li><a href="links/book.php">Adaugă carte</a></li>
                  <li><a href="links/authors_publications.php">Autori și publicații</a></li>
                  <li><a href="links/users.php">Utilizatori</a></li>';

          }
          echo '<li><a href="links/reservations.php">Rezervări</a></li>
                <li><a href="links/profile.php">Profil</a></li>
                <li><a href="links/logout.php">Deconectare</a></li>';
        }
        ?>
			<li><a href="#footer">Contact</a></li>
		</ul>
	</nav>

</header>
</body>
</html>

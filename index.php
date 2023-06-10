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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="CSS/style.css">
  <title>Home</title>
</head>
<body>
  <header id="main-menu">
	<nav class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
          <div class="logo-container">
            <a href="SQL/index.php" class="logo">
              <img id="logo" src="Images/novella_logo.png" alt="Combs 'n' Fro Logo"/>
            </a>
          </div>
      </div>
    </div>
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
